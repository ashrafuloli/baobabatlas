<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
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
        $refund = DB::transaction(
            function () use ($refundRequest): Refund {
                $refundRequest = RefundRequest::query()
                    ->whereKey($refundRequest->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $refundRequest->status
                    !== RefundRequest::STATUS_APPROVED
                ) {
                    throw new RuntimeException(
                        'Only an approved refund request can be processed.',
                    );
                }

                $order = Order::query()
                    ->whereKey($refundRequest->order_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a Stripe refund.',
                    );
                }

                if (
                    ! filled($order->stripe_payment_intent_id)
                ) {
                    throw new RuntimeException(
                        'The Stripe payment intent is missing.',
                    );
                }

                $existingRefund = Refund::query()
                    ->where(
                        'refund_request_id',
                        $refundRequest->id,
                    )
                    ->lockForUpdate()
                    ->first();

                if ($existingRefund !== null) {
                    if ($existingRefund->isSucceeded()) {
                        return $existingRefund;
                    }

                    /*
                     * If Stripe already returned a refund ID,
                     * do not create another Stripe refund.
                     */
                    if (filled($existingRefund->stripe_refund_id)) {
                        return $existingRefund;
                    }

                    /*
                     * A pending/failed local refund without a Stripe ID
                     * can safely be retried using the same idempotency key
                     * and the same amount stored in the Refund record.
                     */
                    return $existingRefund;
                }

                $successfulRefundedAmount = (float) $order->refunds()
                    ->where(
                        'status',
                        Refund::STATUS_SUCCEEDED,
                    )
                    ->sum('amount');

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

                $requestedRefundAmount = min(
                    round(
                        (float) $refundRequest->amount,
                        2,
                    ),
                    $remainingRefundableAmount,
                );

                $deductionAmount = max(
                    0,
                    round(
                        (float) $refundRequest->deduction_amount,
                        2,
                    ),
                );

                if ($deductionAmount > $requestedRefundAmount) {
                    throw new RuntimeException(
                        'The deduction amount cannot exceed the refundable amount.',
                    );
                }

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
                 * Create the local refund record BEFORE contacting Stripe.
                 *
                 * This permanently associates this refund operation with
                 * one Stripe idempotency key and one refund amount.
                 */
                return Refund::query()->create([
                    'order_id' => $order->id,
                    'refund_request_id' => $refundRequest->id,
                    'stripe_refund_id' => null,
                    'stripe_idempotency_key' => Str::uuid()->toString(),
                    'amount' => $finalRefundAmount,
                    'currency' => strtolower(
                        (string) $order->currency,
                    ),
                    'status' => Refund::STATUS_PENDING,
                ]);
            },
        );

        /*
         * Stripe has already successfully processed this refund.
         */
        if ($refund->isSucceeded()) {
            return $refund->fresh();
        }

        /*
         * If Stripe already returned an object for this refund,
         * never create another refund operation.
         */
        if (filled($refund->stripe_refund_id)) {
            return $refund->fresh();
        }

        $order = $refund->order()->firstOrFail();

        $stripeSecret = config('services.stripe.secret');

        if (
            ! is_string($stripeSecret)
            || $stripeSecret === ''
        ) {
            $this->markAsFailed(
                $refund->id,
            );

            throw new RuntimeException(
                'Stripe secret key is not configured.',
            );
        }

        $stripe = new StripeClient($stripeSecret);

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
                     * IMPORTANT:
                     * This key is generated once and persisted
                     * with the Refund record.
                     */
                    'idempotency_key' =>
                        $refund->stripe_idempotency_key,
                ],
            );
        } catch (ApiErrorException $exception) {
            report($exception);

            $this->markAsFailed($refund->id);

            throw new RuntimeException(
                'Stripe refund failed: '
                . $exception->getMessage(),
                previous: $exception,
            );
        }

        return DB::transaction(
            function () use (
                $refund,
                $stripeRefund,
            ): Refund {
                $refund = Refund::query()
                    ->whereKey($refund->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                 * Another request may have completed the refund while
                 * this request was communicating with Stripe.
                 */
                if (
                    $refund->isSucceeded()
                    && filled($refund->stripe_refund_id)
                ) {
                    return $refund;
                }

                $refund->update([
                    'stripe_refund_id' => $stripeRefund->id,
                    'status' => $stripeRefund->status,
                ]);

                if (
                    $stripeRefund->status
                    === Refund::STATUS_SUCCEEDED
                ) {
                    $order = $refund->order()
                        ->lockForUpdate()
                        ->firstOrFail();

                    $order->update([
                        'refund_status' =>
                            Order::REFUND_STATUS_REFUNDED,
                    ]);
                }

                return $refund->fresh();
            },
        );
    }

    private function markAsFailed(int $refundId): void
    {
        DB::transaction(
            function () use ($refundId): void {
                Refund::query()
                    ->whereKey($refundId)
                    ->lockForUpdate()
                    ->update([
                        'status' => Refund::STATUS_FAILED,
                    ]);
            },
        );
    }
}
