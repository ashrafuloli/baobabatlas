<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Refund;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

final class RefundOrder
{
    public function execute(
        RefundRequest $refundRequest,
    ): Refund {
        /*
        |--------------------------------------------------------------------------
        | Create / Retrieve Local Refund
        |--------------------------------------------------------------------------
        */

        $refund = DB::transaction(
            function () use ($refundRequest): Refund {
                /*
                |--------------------------------------------------------------------------
                | Lock Refund Request
                |--------------------------------------------------------------------------
                */

                $refundRequest = RefundRequest::query()
                    ->whereKey($refundRequest->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Validate Refund Request
                |--------------------------------------------------------------------------
                */

                if (
                    $refundRequest->status
                    !== RefundRequest::STATUS_APPROVED
                ) {
                    throw new RuntimeException(
                        'Only an approved refund request can be processed.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Lock Order
                |--------------------------------------------------------------------------
                */

                $order = Order::query()
                    ->whereKey($refundRequest->order_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Validate Payment
                |--------------------------------------------------------------------------
                */

                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a Stripe refund because the payment has not been completed.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Stripe Payment Intent
                |--------------------------------------------------------------------------
                */

                if (
                    !filled($order->stripe_payment_intent_id)
                ) {
                    throw new RuntimeException(
                        'The Stripe payment intent is missing.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Check Existing Refund
                |--------------------------------------------------------------------------
                |
                | One Refund belongs to one RefundRequest.
                |
                */

                $existingRefund = Refund::query()
                    ->where(
                        'refund_request_id',
                        $refundRequest->id,
                    )
                    ->lockForUpdate()
                    ->first();

                if ($existingRefund !== null) {
                    /*
                    |--------------------------------------------------------------------------
                    | Already Successfully Refunded
                    |--------------------------------------------------------------------------
                    */

                    if ($existingRefund->isSucceeded()) {
                        return $existingRefund;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Stripe Refund Already Exists
                    |--------------------------------------------------------------------------
                    |
                    | Never create another Stripe refund when a Stripe
                    | refund ID is already stored.
                    |
                    */

                    if (
                        filled(
                            $existingRefund->stripe_refund_id,
                        )
                    ) {
                        return $existingRefund;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Existing Pending / Failed Refund
                    |--------------------------------------------------------------------------
                    |
                    | Reuse the existing refund and its persisted
                    | idempotency key.
                    |
                    */

                    return $existingRefund;
                }

                /*
                |--------------------------------------------------------------------------
                | Calculate Successfully Refunded Amount
                |--------------------------------------------------------------------------
                */

                $successfulRefundedAmount = round(
                    (float) $order->refunds()
                        ->where(
                            'status',
                            Refund::STATUS_SUCCEEDED,
                        )
                        ->sum('amount'),
                    2,
                );

                /*
                |--------------------------------------------------------------------------
                | Calculate Remaining Refundable Amount
                |--------------------------------------------------------------------------
                |
                | Shipping is non-refundable.
                |
                */

                $remainingRefundableAmount = max(
                    0,
                    round(
                        (float) $order->total
                        - (float) $order->shipping
                        - $successfulRefundedAmount,
                        2,
                    ),
                );

                if ($remainingRefundableAmount <= 0) {
                    throw new RuntimeException(
                        'There is no refundable amount remaining for this order.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Requested Refund Amount
                |--------------------------------------------------------------------------
                */

                $requestedRefundAmount = round(
                    (float) $refundRequest->amount,
                    2,
                );

                if ($requestedRefundAmount <= 0) {
                    throw new RuntimeException(
                        'The requested refund amount must be greater than zero.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Never Exceed Remaining Refundable Amount
                |--------------------------------------------------------------------------
                */

                if (
                    $requestedRefundAmount
                    > $remainingRefundableAmount
                ) {
                    throw new RuntimeException(
                        'The requested refund amount exceeds the remaining refundable amount.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Deduction
                |--------------------------------------------------------------------------
                */

                $deductionAmount = max(
                    0,
                    round(
                        (float) $refundRequest->deduction_amount,
                        2,
                    ),
                );

                if (
                    $deductionAmount
                    > $requestedRefundAmount
                ) {
                    throw new RuntimeException(
                        'The deduction amount cannot exceed the requested refund amount.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Final Stripe Refund Amount
                |--------------------------------------------------------------------------
                */

                $finalRefundAmount = round(
                    $requestedRefundAmount
                    - $deductionAmount,
                    2,
                );

                if ($finalRefundAmount <= 0) {
                    throw new RuntimeException(
                        'There is no refundable amount remaining after the deduction.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Create Local Refund
                |--------------------------------------------------------------------------
                |
                | The Stripe idempotency key is generated once and persisted.
                |
                */

                return Refund::query()->create([
                    'order_id' => $order->id,

                    'refund_request_id' =>
                        $refundRequest->id,

                    'stripe_refund_id' => null,

                    'stripe_idempotency_key' =>
                        Str::uuid()->toString(),

                    'amount' => $finalRefundAmount,

                    'currency' => strtolower(
                        (string) $order->currency,
                    ),

                    'status' => Refund::STATUS_PENDING,
                ]);
            },
        );

        /*
        |--------------------------------------------------------------------------
        | Already Successfully Refunded
        |--------------------------------------------------------------------------
        */

        if ($refund->isSucceeded()) {
            return $refund->fresh();
        }

        /*
        |--------------------------------------------------------------------------
        | Stripe Refund Already Exists
        |--------------------------------------------------------------------------
        */

        if (
            filled($refund->stripe_refund_id)
        ) {
            return $refund->fresh();
        }

        /*
        |--------------------------------------------------------------------------
        | Load Order
        |--------------------------------------------------------------------------
        */

        $order = $refund->order()
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Stripe Configuration
        |--------------------------------------------------------------------------
        */

        $stripeSecret = config('services.stripe.secret');

        if (
            !is_string($stripeSecret)
            || $stripeSecret === ''
        ) {
            $this->markAsFailed(
                $refund->id,
            );

            throw new RuntimeException(
                'Stripe secret key is not configured.',
            );
        }

        $stripe = new StripeClient(
            $stripeSecret,
        );

        /*
        |--------------------------------------------------------------------------
        | Create Stripe Refund
        |--------------------------------------------------------------------------
        */

        try {
            $stripeRefund = $stripe->refunds->create(
                [
                    'payment_intent' =>
                        $order->stripe_payment_intent_id,

                    'amount' => (int) round(
                        (float) $refund->amount * 100,
                    ),
                ],
                [
                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANT
                    |--------------------------------------------------------------------------
                    |
                    | Always reuse the same persisted idempotency key.
                    |
                    */

                    'idempotency_key' =>
                        $refund->stripe_idempotency_key,
                ],
            );
        } catch (ApiErrorException $exception) {
            report($exception);

            $this->markAsFailed(
                $refund->id,
            );

            throw new RuntimeException(
                'Stripe refund failed: '
                . $exception->getMessage(),
                previous: $exception,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Store Stripe Result + Restore Stock
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use (
                $refund,
                $stripeRefund,
            ): Refund {
                /*
                |--------------------------------------------------------------------------
                | Lock Refund
                |--------------------------------------------------------------------------
                */

                $refund = Refund::query()
                    ->whereKey($refund->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Prevent Duplicate Processing
                |--------------------------------------------------------------------------
                */

                if (
                    $refund->isSucceeded()
                    && filled(
                        $refund->stripe_refund_id,
                    )
                ) {
                    return $refund;
                }

                /*
                |--------------------------------------------------------------------------
                | Store Stripe Result
                |--------------------------------------------------------------------------
                */

                $refund->update([
                    'stripe_refund_id' =>
                        $stripeRefund->id,

                    'status' =>
                        $stripeRefund->status,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Stripe Refund Successful
                |--------------------------------------------------------------------------
                */

                if (
                    $stripeRefund->status
                    === Refund::STATUS_SUCCEEDED
                ) {
                    /*
                    |--------------------------------------------------------------------------
                    | Lock Order
                    |--------------------------------------------------------------------------
                    */

                    $order = $refund->order()
                        ->lockForUpdate()
                        ->firstOrFail();

                    /*
                    |--------------------------------------------------------------------------
                    | Restore Stock
                    |--------------------------------------------------------------------------
                    |
                    | Only restore stock when this refund represents the
                    | entire remaining refundable amount.
                    |
                    | Deduction does NOT affect stock quantity because the
                    | deduction is a financial adjustment, not a quantity
                    | adjustment.
                    |
                    */

                    if (
                        $this->isFullRefund(
                            $refund,
                            $order,
                        )
                    ) {
                        $this->restoreStock(
                            $refund,
                            $order,
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Mark Order Refunded
                    |--------------------------------------------------------------------------
                    */

                    $order->update([
                        'refund_status' =>
                            Order::REFUND_STATUS_REFUNDED,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Return Fresh Refund
                |--------------------------------------------------------------------------
                */

                return $refund->fresh();
            },
        );
    }

    /**
     * Determine whether the refund represents the full remaining
     * refundable amount.
     *
     * No `is_full_refund` column is required.
     */
    private function isFullRefund(
        Refund $refund,
        Order $order,
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Load Refund Request
        |--------------------------------------------------------------------------
        */

        $refundRequest = RefundRequest::query()
            ->whereKey(
                $refund->refund_request_id,
            )
            ->first();

        if ($refundRequest === null) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Previously Successful Refunds
        |--------------------------------------------------------------------------
        |
        | Current refund is still being processed and therefore is not
        | included because its status has not yet been persisted as
        | succeeded when this method is called.
        |
        */

        $alreadyRefunded = round(
            (float) $order->refunds()
                ->where(
                    'status',
                    Refund::STATUS_SUCCEEDED,
                )
                ->whereKeyNot($refund->id)
                ->sum('amount'),
            2,
        );

        /*
        |--------------------------------------------------------------------------
        | Remaining Refundable Amount
        |--------------------------------------------------------------------------
        */

        $remainingRefundableAmount = max(
            0,
            round(
                (float) $order->total
                - (float) $order->shipping
                - $alreadyRefunded,
                2,
            ),
        );

        /*
        |--------------------------------------------------------------------------
        | Requested Amount
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | We compare the REQUESTED amount, not the final Stripe amount.
        |
        | Example:
        |
        | Remaining refundable = $100
        | Admin deduction = $10
        | Stripe refund = $90
        |
        | This is still a full product refund, therefore stock must
        | be restored.
        |
        */

        $requestedAmount = round(
            (float) $refundRequest->amount,
            2,
        );

        return abs(
                $requestedAmount
                - $remainingRefundableAmount,
            ) < 0.01;
    }

    /**
     * Restore stock for a full refund.
     */
    private function restoreStock(
        Refund $refund,
        Order $order,
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Load Order Items
        |--------------------------------------------------------------------------
        */

        $order->loadMissing('items');

        if ($order->items->isEmpty()) {
            throw new RuntimeException(
                'Cannot restore stock because the order has no items.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Inventory Reference
        |--------------------------------------------------------------------------
        */

        $reference = 'REFUND-' . $refund->id;

        /*
        |--------------------------------------------------------------------------
        | Restore Each Order Item
        |--------------------------------------------------------------------------
        */

        foreach ($order->items as $orderItem) {
            $quantity = (int) $orderItem->quantity;

            if ($quantity < 1) {
                throw new RuntimeException(
                    sprintf(
                        'Invalid quantity for order item #%d.',
                        $orderItem->id,
                    ),
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Check Existing Inventory Transaction
            |--------------------------------------------------------------------------
            |
            | This makes stock restoration idempotent.
            |
            */

            $alreadyRestored = InventoryTransaction::query()
                ->where(
                    'reference',
                    $reference,
                )
                ->where(
                    'product_id',
                    $orderItem->product_id,
                )
                ->when(
                    $orderItem->variant_id !== null,
                    function ($query) use ($orderItem): void {
                        $query->where(
                            'product_variant_id',
                            $orderItem->variant_id,
                        );
                    },
                    function ($query): void {
                        $query->whereNull(
                            'product_variant_id',
                        );
                    },
                )
                ->exists();

            if ($alreadyRestored) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPLE PRODUCT
            |--------------------------------------------------------------------------
            |
            | variant_id = NULL
            | stock = products.stock
            |
            */

            if ($orderItem->variant_id === null) {
                $product = Product::query()
                    ->whereKey(
                        $orderItem->product_id,
                    )
                    ->lockForUpdate()
                    ->first();

                if ($product === null) {
                    throw new RuntimeException(
                        sprintf(
                            'Product #%d could not be found while restoring stock.',
                            $orderItem->product_id,
                        ),
                    );
                }

                if (!$product->isSimple()) {
                    throw new RuntimeException(
                        sprintf(
                            'Product #%d is not a simple product.',
                            $product->id,
                        ),
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Restore Simple Product Stock
                |--------------------------------------------------------------------------
                */

                $stockBefore = (int) $product->stock;

                $product->increment(
                    'stock',
                    $quantity,
                );

                $product->refresh();

                /*
                |--------------------------------------------------------------------------
                | Create Inventory Transaction
                |--------------------------------------------------------------------------
                */

                InventoryTransaction::query()->create([
                    'product_id' => $product->id,

                    'product_variant_id' => null,

                    'type' => 'refund',

                    'quantity' => $quantity,

                    'reference' => $reference,

                    'note' => sprintf(
                        'Stock restored for refund %s, order %s.',
                        $refund->id,
                        $order->order_number,
                    ),
                ]);

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | VARIABLE PRODUCT
            |--------------------------------------------------------------------------
            |
            | variant_id = actual variant
            | stock = product_variants.stock
            |
            */

            $variant = ProductVariant::query()
                ->whereKey(
                    $orderItem->variant_id,
                )
                ->where(
                    'product_id',
                    $orderItem->product_id,
                )
                ->lockForUpdate()
                ->first();

            if ($variant === null) {
                throw new RuntimeException(
                    sprintf(
                        'Variant #%d could not be found while restoring stock.',
                        $orderItem->variant_id,
                    ),
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Restore Variant Stock
            |--------------------------------------------------------------------------
            */

            $stockBefore = (int) $variant->stock;

            $variant->increment(
                'stock',
                $quantity,
            );

            $variant->refresh();

            /*
            |--------------------------------------------------------------------------
            | Create Inventory Transaction
            |--------------------------------------------------------------------------
            */

            InventoryTransaction::query()->create([
                'product_id' =>
                    $orderItem->product_id,

                'product_variant_id' =>
                    $variant->id,

                'type' => 'refund',

                'quantity' => $quantity,

                'reference' => $reference,

                'note' => sprintf(
                    'Stock restored for refund %s, order %s.',
                    $refund->id,
                    $order->order_number,
                ),
            ]);
        }
    }

    /**
     * Mark a local refund as failed.
     */
    private function markAsFailed(
        int $refundId,
    ): void {
        DB::transaction(
            function () use ($refundId): void {
                Refund::query()
                    ->whereKey($refundId)
                    ->lockForUpdate()
                    ->update([
                        'status' =>
                            Refund::STATUS_FAILED,
                    ]);
            },
        );
    }
}
