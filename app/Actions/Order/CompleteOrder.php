<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Cart;
use App\Models\InventoryTransaction;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

final class CompleteOrder
{
    public function execute(
        Order $order,
        ?string $stripeCheckoutSessionId = null,
        ?string $stripePaymentIntentId = null,
    ): Order {
        Log::info(
            'CompleteOrder execution started.',
            [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'stripe_checkout_session_id' =>
                    $stripeCheckoutSessionId,
                'stripe_payment_intent_id' =>
                    $stripePaymentIntentId,
            ],
        );

        return DB::transaction(function () use (
            $order,
            $stripeCheckoutSessionId,
            $stripePaymentIntentId,
        ): Order {
            /*
            |--------------------------------------------------------------------------
            | Lock Order
            |--------------------------------------------------------------------------
            */

            $order = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->with('items')
                ->firstOrFail();

            Log::info(
                'CompleteOrder locked order.',
                [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                ],
            );

            /*
            |--------------------------------------------------------------------------
            | Already Paid
            |--------------------------------------------------------------------------
            |
            | Important:
            | Do not process stock again if the webhook and checkout success
            | fallback both attempt to complete the same order.
            |
            */

            if ($order->isPaid()) {
                Log::info(
                    'CompleteOrder skipped because order is already paid.',
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ],
                );

                return $order;
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Order Status
            |--------------------------------------------------------------------------
            */

            if (!$order->isPending()) {
                Log::warning(
                    'CompleteOrder rejected because order is not pending.',
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'payment_status' => $order->payment_status,
                    ],
                );

                throw ValidationException::withMessages([
                    'order' => 'This order cannot be completed.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Stripe Checkout Session
            |--------------------------------------------------------------------------
            */

            if (
                $stripeCheckoutSessionId !== null
                && $stripeCheckoutSessionId !== ''
                && $order->stripe_checkout_session_id !== null
                && $order->stripe_checkout_session_id
                !== $stripeCheckoutSessionId
            ) {
                Log::error(
                    'CompleteOrder Stripe Checkout Session mismatch.',
                    [
                        'order_id' => $order->id,
                        'stored_session_id' =>
                            $order->stripe_checkout_session_id,
                        'received_session_id' =>
                            $stripeCheckoutSessionId,
                    ],
                );

                throw ValidationException::withMessages([
                    'order' =>
                        'The Stripe Checkout Session does not match this order.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Stripe Payment Intent
            |--------------------------------------------------------------------------
            */

            if (
                $stripePaymentIntentId !== null
                && $stripePaymentIntentId !== ''
                && $order->stripe_payment_intent_id !== null
                && $order->stripe_payment_intent_id
                !== $stripePaymentIntentId
            ) {
                Log::error(
                    'CompleteOrder Stripe Payment Intent mismatch.',
                    [
                        'order_id' => $order->id,
                        'stored_payment_intent_id' =>
                            $order->stripe_payment_intent_id,
                        'received_payment_intent_id' =>
                            $stripePaymentIntentId,
                    ],
                );

                throw ValidationException::withMessages([
                    'order' =>
                        'The Stripe Payment Intent does not match this order.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Order Items
            |--------------------------------------------------------------------------
            */

            if ($order->items->isEmpty()) {
                Log::error(
                    'CompleteOrder failed because order has no items.',
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ],
                );

                throw ValidationException::withMessages([
                    'order' => 'This order does not contain any items.',
                ]);
            }

            Log::info(
                'CompleteOrder validating order items.',
                [
                    'order_id' => $order->id,
                    'item_count' => $order->items->count(),
                ],
            );

            /*
            |--------------------------------------------------------------------------
            | Prepare Stock Operations
            |--------------------------------------------------------------------------
            |
            | Simple product:
            |     products.stock
            |
            | Variable product:
            |     product_variants.stock
            |
            | Stock is only reduced after payment has been confirmed.
            |
            */

            $stockItems = [];

            foreach ($order->items as $item) {
                $quantity = (int) $item->quantity;

                /*
                |--------------------------------------------------------------------------
                | Validate Quantity
                |--------------------------------------------------------------------------
                */

                if ($quantity < 1) {
                    Log::error(
                        'CompleteOrder found invalid order quantity.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'product_name' => $item->product_name,
                            'quantity' => $quantity,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'Invalid quantity for "%s".',
                            $item->product_name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Lock Product
                |--------------------------------------------------------------------------
                |
                | Product must always be locked because:
                |
                | 1. Simple products store stock here.
                | 2. We need to verify the product type.
                |
                */

                $product = Product::query()
                    ->whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if (
                    $product === null
                    || !$product->isActive()
                ) {
                    Log::error(
                        'CompleteOrder product is unavailable.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'product_id' => $item->product_id,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'The product "%s" is no longer available.',
                            $item->product_name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | SIMPLE PRODUCT
                |--------------------------------------------------------------------------
                */

                if ($product->isSimple()) {
                    /*
                    |--------------------------------------------------------------------------
                    | Simple Product Must Not Have Variant
                    |--------------------------------------------------------------------------
                    */

                    if ($item->variant_id !== null) {
                        Log::error(
                            'CompleteOrder found variant on simple product.',
                            [
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'product_id' => $product->id,
                                'variant_id' => $item->variant_id,
                            ],
                        );

                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'The order item for "%s" contains an invalid variant.',
                                $item->product_name,
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Validate Simple Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $stock = (int) $product->stock;

                    if ($stock < $quantity) {
                        Log::warning(
                            'CompleteOrder insufficient simple product stock.',
                            [
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'product_id' => $product->id,
                                'current_stock' => $stock,
                                'requested_quantity' => $quantity,
                            ],
                        );

                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'Only %d item(s) are available for "%s".',
                                $stock,
                                $item->product_name,
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Aggregate Simple Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $key = 'product:' . $product->id;

                    if (isset($stockItems[$key])) {
                        $stockItems[$key]['quantity'] += $quantity;
                    } else {
                        $stockItems[$key] = [
                            'type' => 'simple',
                            'product' => $product,
                            'variant' => null,
                            'quantity' => $quantity,
                            'product_name' => $item->product_name,
                        ];
                    }

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | VARIABLE PRODUCT
                |--------------------------------------------------------------------------
                */

                if ($product->isVariable()) {
                    /*
                    |--------------------------------------------------------------------------
                    | Variable Product Requires Variant
                    |--------------------------------------------------------------------------
                    */

                    if ($item->variant_id === null) {
                        Log::error(
                            'CompleteOrder variable product has no variant.',
                            [
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'product_id' => $product->id,
                            ],
                        );

                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'A variant is required for "%s".',
                                $item->product_name,
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Variant
                    |--------------------------------------------------------------------------
                    */

                    $variant = ProductVariant::query()
                        ->whereKey($item->variant_id)
                        ->where('product_id', $product->id)
                        ->lockForUpdate()
                        ->first();

                    if (
                        $variant === null
                        || !$variant->isActive()
                    ) {
                        Log::error(
                            'CompleteOrder variant is unavailable.',
                            [
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'product_id' => $product->id,
                                'variant_id' => $item->variant_id,
                            ],
                        );

                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'The selected variant for "%s" is no longer available.',
                                $item->product_name,
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Validate Variant Stock
                    |--------------------------------------------------------------------------
                    */

                    $stock = (int) $variant->stock;

                    if ($stock < $quantity) {
                        Log::warning(
                            'CompleteOrder insufficient variant stock.',
                            [
                                'order_id' => $order->id,
                                'order_item_id' => $item->id,
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'current_stock' => $stock,
                                'requested_quantity' => $quantity,
                            ],
                        );

                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'Only %d item(s) are available for "%s".',
                                $stock,
                                $item->product_name,
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Aggregate Variant Stock
                    |--------------------------------------------------------------------------
                    */

                    $key = 'variant:' . $variant->id;

                    if (isset($stockItems[$key])) {
                        $stockItems[$key]['quantity'] += $quantity;
                    } else {
                        $stockItems[$key] = [
                            'type' => 'variable',
                            'product' => $product,
                            'variant' => $variant,
                            'quantity' => $quantity,
                            'product_name' => $item->product_name,
                        ];
                    }

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Invalid Product Type
                |--------------------------------------------------------------------------
                */

                Log::error(
                    'CompleteOrder found invalid product type.',
                    [
                        'order_id' => $order->id,
                        'order_item_id' => $item->id,
                        'product_id' => $product->id,
                        'product_type' => $product->type,
                    ],
                );

                throw ValidationException::withMessages([
                    'order' => sprintf(
                        'The product "%s" has an invalid product type.',
                        $item->product_name,
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Reduce Stock & Create Inventory Transactions
            |--------------------------------------------------------------------------
            */

            foreach ($stockItems as $stockItem) {
                $quantity = (int) $stockItem['quantity'];

                /** @var Product $product */
                $product = $stockItem['product'];

                /** @var ProductVariant|null $variant */
                $variant = $stockItem['variant'];

                /*
                |--------------------------------------------------------------------------
                | SIMPLE PRODUCT STOCK
                |--------------------------------------------------------------------------
                */

                if ($stockItem['type'] === 'simple') {
                    $stockBefore = (int) $product->stock;

                    /*
                    |--------------------------------------------------------------------------
                    | Final Stock Check
                    |--------------------------------------------------------------------------
                    */

                    if ($stockBefore < $quantity) {
                        throw ValidationException::withMessages([
                            'order' => sprintf(
                                'Only %d item(s) are available for "%s".',
                                $stockBefore,
                                $stockItem['product_name'],
                            ),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Reduce Product Stock
                    |--------------------------------------------------------------------------
                    */

                    $product->decrement(
                        'stock',
                        $quantity,
                    );

                    $product->refresh();

                    /*
                    |--------------------------------------------------------------------------
                    | Inventory Transaction
                    |--------------------------------------------------------------------------
                    */

                    InventoryTransaction::query()->create([
                        'product_id' => $product->id,

                        'product_variant_id' => null,

                        'type' => 'sale',

                        'quantity' => -$quantity,

                        'reference' => $order->order_number,

                        'note' => sprintf(
                            'Stock reduced for order %s.',
                            $order->order_number,
                        ),
                    ]);

                    Log::info(
                        'CompleteOrder reduced simple product stock.',
                        [
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'stock_before' => $stockBefore,
                            'quantity' => $quantity,
                            'stock_after' => (int) $product->stock,
                        ],
                    );

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | VARIABLE PRODUCT STOCK
                |--------------------------------------------------------------------------
                */

                if ($variant === null) {
                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'The variant for "%s" could not be found.',
                            $stockItem['product_name'],
                        ),
                    ]);
                }

                $stockBefore = (int) $variant->stock;

                /*
                |--------------------------------------------------------------------------
                | Final Stock Check
                |--------------------------------------------------------------------------
                */

                if ($stockBefore < $quantity) {
                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'Only %d item(s) are available for "%s".',
                            $stockBefore,
                            $stockItem['product_name'],
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Reduce Variant Stock
                |--------------------------------------------------------------------------
                */

                $variant->decrement(
                    'stock',
                    $quantity,
                );

                $variant->refresh();

                /*
                |--------------------------------------------------------------------------
                | Inventory Transaction
                |--------------------------------------------------------------------------
                */

                InventoryTransaction::query()->create([
                    'product_id' => $product->id,

                    'product_variant_id' => $variant->id,

                    'type' => 'sale',

                    'quantity' => -$quantity,

                    'reference' => $order->order_number,

                    'note' => sprintf(
                        'Stock reduced for order %s.',
                        $order->order_number,
                    ),
                ]);

                Log::info(
                    'CompleteOrder reduced variant stock.',
                    [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'stock_before' => $stockBefore,
                        'quantity' => $quantity,
                        'stock_after' => (int) $variant->stock,
                    ],
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Payment Information
            |--------------------------------------------------------------------------
            */

            $sessionId =
                $stripeCheckoutSessionId
                ?? $order->stripe_checkout_session_id;

            $paymentIntentId =
                $stripePaymentIntentId
                ?? $order->stripe_payment_intent_id;

            /*
            |--------------------------------------------------------------------------
            | Mark Order Paid
            |--------------------------------------------------------------------------
            */

            $order->update([
                'status' => Order::STATUS_PAID,

                'payment_status' => Order::PAYMENT_STATUS_PAID,

                'payment_gateway' => 'stripe',

                'stripe_checkout_session_id' => $sessionId,

                'stripe_payment_intent_id' => $paymentIntentId,

                'paid_at' => $order->paid_at ?? now(),
            ]);

            Log::info(
                'CompleteOrder marked order as paid.',
                [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_status' =>
                        Order::PAYMENT_STATUS_PAID,
                    'stripe_checkout_session_id' => $sessionId,
                    'stripe_payment_intent_id' => $paymentIntentId,
                ],
            );

            /*
            |--------------------------------------------------------------------------
            | Remove Only Ordered Items From Cart
            |--------------------------------------------------------------------------
            */

            if ($order->user_id !== null) {
                $cart = Cart::query()
                    ->where('user_id', $order->user_id)
                    ->lockForUpdate()
                    ->first();

                if ($cart === null) {
                    Log::warning(
                        'CompleteOrder could not find user cart.',
                        [
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                        ],
                    );
                } else {
                    foreach ($order->items as $orderItem) {
                        $query = $cart->items()
                            ->where(
                                'product_id',
                                $orderItem->product_id,
                            );

                        if ($orderItem->variant_id === null) {
                            $query->whereNull('variant_id');
                        } else {
                            $query->where(
                                'variant_id',
                                $orderItem->variant_id,
                            );
                        }

                        $deletedCount = $query->delete();

                        Log::info(
                            'CompleteOrder removed ordered cart item.',
                            [
                                'order_id' => $order->id,
                                'cart_id' => $cart->id,
                                'product_id' =>
                                    $orderItem->product_id,
                                'variant_id' =>
                                    $orderItem->variant_id,
                                'deleted_count' => $deletedCount,
                            ],
                        );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Return Fresh Order
            |--------------------------------------------------------------------------
            */

            $completedOrder = $order
                ->refresh()
                ->load('items');

            Log::info(
                'CompleteOrder completed successfully.',
                [
                    'order_id' => $completedOrder->id,
                    'order_number' =>
                        $completedOrder->order_number,
                    'status' => $completedOrder->status,
                    'payment_status' =>
                        $completedOrder->payment_status,
                    'shipping' =>
                        (float) $completedOrder->shipping,
                ],
            );

            return $completedOrder;
        });
    }
}
