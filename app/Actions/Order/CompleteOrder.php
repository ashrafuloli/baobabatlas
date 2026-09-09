<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Cart;
use App\Models\Order;
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
            | Lock & Validate Variants
            |--------------------------------------------------------------------------
            */

            $variants = [];

            foreach ($order->items as $item) {
                $quantity = (int) $item->quantity;

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
                | Non-Variant Product
                |--------------------------------------------------------------------------
                */

                if ($item->variant_id === null) {
                    Log::info(
                        'CompleteOrder found non-variant order item.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'product_id' => $item->product_id,
                            'quantity' => $quantity,
                        ],
                    );

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Lock Variant
                |--------------------------------------------------------------------------
                */

                $variant = ProductVariant::query()
                    ->whereKey($item->variant_id)
                    ->lockForUpdate()
                    ->first();

                if ($variant === null) {
                    Log::error(
                        'CompleteOrder variant not found.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'variant_id' => $item->variant_id,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'The variant for "%s" could not be found.',
                            $item->product_name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Product Relationship
                |--------------------------------------------------------------------------
                */

                if (
                    $item->product_id !== null
                    && (int) $variant->product_id
                    !== (int) $item->product_id
                ) {
                    Log::error(
                        'CompleteOrder variant/product mismatch.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'product_id' => $item->product_id,
                            'variant_id' => $variant->id,
                            'variant_product_id' =>
                                $variant->product_id,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'The selected variant for "%s" is invalid.',
                            $item->product_name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Variant Status
                |--------------------------------------------------------------------------
                */

                if (!$variant->isActive()) {
                    Log::warning(
                        'CompleteOrder variant is inactive.',
                        [
                            'order_id' => $order->id,
                            'variant_id' => $variant->id,
                            'product_id' => $variant->product_id,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'A variant in order %s is no longer available.',
                            $order->order_number,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Stock
                |--------------------------------------------------------------------------
                */

                $currentStock = (int) $variant->stock;

                if ($currentStock < $quantity) {
                    Log::warning(
                        'CompleteOrder insufficient stock.',
                        [
                            'order_id' => $order->id,
                            'order_item_id' => $item->id,
                            'variant_id' => $variant->id,
                            'current_stock' => $currentStock,
                            'requested_quantity' => $quantity,
                        ],
                    );

                    throw ValidationException::withMessages([
                        'order' => sprintf(
                            'Insufficient stock for "%s".',
                            $item->product_name,
                        ),
                    ]);
                }

                $variants[$variant->id] = [
                    'model' => $variant,
                    'quantity' => $quantity,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Reduce Variant Stock
            |--------------------------------------------------------------------------
            */

            foreach ($variants as $variantData) {
                /** @var ProductVariant $variant */
                $variant = $variantData['model'];

                $quantity = (int) $variantData['quantity'];
                $stockBefore = (int) $variant->stock;

                Log::info(
                    'CompleteOrder reducing variant stock.',
                    [
                        'order_id' => $order->id,
                        'variant_id' => $variant->id,
                        'stock_before' => $stockBefore,
                        'quantity' => $quantity,
                    ],
                );

                $variant->decrement(
                    'stock',
                    $quantity,
                );

                $variant->refresh();

                Log::info(
                    'CompleteOrder variant stock reduced.',
                    [
                        'order_id' => $order->id,
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
                    'payment_status' => Order::PAYMENT_STATUS_PAID,
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
                ],
            );

            return $completedOrder;
        });
    }
}
