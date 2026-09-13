<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Order;
use RuntimeException;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

final class CreateStripeCheckoutSession
{
    /**
     * Create or reuse a Stripe Checkout Session for an order.
     *
     * OrderItem line_total is the authoritative merchandise amount.
     * Order shipping is added once as a separate Stripe line item.
     * Order tax is added once as a separate Stripe line item.
     *
     * @throws ApiErrorException
     */
    public function execute(Order $order): Session
    {
        $secretKey = config('services.stripe.secret');

        if (!is_string($secretKey) || trim($secretKey) === '') {
            throw new RuntimeException(
                'Stripe secret key is not configured.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Order State
        |--------------------------------------------------------------------------
        */

        if ($order->status !== Order::STATUS_PENDING) {
            throw new RuntimeException(
                'A Checkout Session can only be created for a pending order.',
            );
        }

        if ($order->payment_status !== Order::PAYMENT_STATUS_PENDING) {
            throw new RuntimeException(
                'A Checkout Session can only be created for a pending payment.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Load Order Items
        |--------------------------------------------------------------------------
        */

        $order->loadMissing('items');

        if ($order->items->isEmpty()) {
            throw new RuntimeException(
                'Cannot create Stripe Checkout Session for an empty order.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Stripe Client
        |--------------------------------------------------------------------------
        */

        $stripe = new StripeClient($secretKey);

        /*
        |--------------------------------------------------------------------------
        | Reuse Existing Open Checkout Session
        |--------------------------------------------------------------------------
        */

        $existingSessionId = trim(
            (string) $order->stripe_checkout_session_id,
        );

        if ($existingSessionId !== '') {
            try {
                $existingSession = $stripe->checkout->sessions->retrieve(
                    $existingSessionId,
                );

                if (
                    $existingSession->status === 'open'
                    && is_string($existingSession->url)
                    && trim($existingSession->url) !== ''
                ) {
                    return $existingSession;
                }
            } catch (ApiErrorException) {
                /*
                |--------------------------------------------------------------------------
                | Existing Session Unavailable
                |--------------------------------------------------------------------------
                |
                | Continue with a new Checkout Session.
                |
                */
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency = strtolower(
            trim(
                (string) (
                $order->currency
                    ?: setting('currency', 'USD')
                ),
            ),
        );

        if (
            strlen($currency) !== 3
            || !ctype_alpha($currency)
        ) {
            throw new RuntimeException(
                'Invalid order currency.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Build Stripe Merchandise Line Items
        |--------------------------------------------------------------------------
        |
        | OrderItem.line_total is authoritative.
        |
        | Stripe requires integer amounts in the smallest currency unit.
        | When line_total is not evenly divisible by quantity, the line
        | item is split into two Stripe line items so the exact order
        | amount is preserved.
        |
        */

        $lineItems = [];
        $stripeTotalCents = 0;

        foreach ($order->items as $item) {
            $quantity = (int) $item->quantity;

            if ($quantity < 1) {
                throw new RuntimeException(
                    'Invalid order item quantity.',
                );
            }

            $lineTotalCents = (int) round(
                (float) $item->line_total * 100,
            );

            if ($lineTotalCents < 0) {
                throw new RuntimeException(
                    'Invalid order item total.',
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Zero-Value Merchandise
            |--------------------------------------------------------------------------
            */

            if ($lineTotalCents === 0) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Calculate Per-Unit Stripe Amount
            |--------------------------------------------------------------------------
            */

            $baseCents = intdiv(
                $lineTotalCents,
                $quantity,
            );

            $remainder = $lineTotalCents % $quantity;

            /*
            |--------------------------------------------------------------------------
            | Stripe Does Not Accept Zero Unit Amount
            |--------------------------------------------------------------------------
            */

            if ($baseCents < 1) {
                throw new RuntimeException(
                    'An order item has an invalid amount for Stripe Checkout.',
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Base Quantity
            |--------------------------------------------------------------------------
            */

            $baseQuantity = $quantity - $remainder;

            if ($baseQuantity > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => $item->product_name,
                        ],
                        'unit_amount' => $baseCents,
                    ],
                    'quantity' => $baseQuantity,
                ];

                $stripeTotalCents +=
                    $baseCents * $baseQuantity;
            }

            /*
            |--------------------------------------------------------------------------
            | Remainder Quantity
            |--------------------------------------------------------------------------
            */

            if ($remainder > 0) {
                $remainderCents = $baseCents + 1;

                $lineItems[] = [
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => $item->product_name,
                        ],
                        'unit_amount' => $remainderCents,
                    ],
                    'quantity' => $remainder,
                ];

                $stripeTotalCents +=
                    $remainderCents * $remainder;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Shipping
        |--------------------------------------------------------------------------
        |
        | Order.shipping is the final customer-facing shipping amount.
        |
        | Shipping is added exactly once and is never multiplied by
        | product quantity.
        |
        */

        $shippingAmountCents = (int) round(
            (float) $order->shipping * 100,
        );

        if ($shippingAmountCents < 0) {
            throw new RuntimeException(
                'Invalid shipping amount.',
            );
        }

        if ($shippingAmountCents > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Shipping',
                    ],
                    'unit_amount' => $shippingAmountCents,
                ],
                'quantity' => 1,
            ];

            $stripeTotalCents += $shippingAmountCents;
        }

        /*
        |--------------------------------------------------------------------------
        | Tax
        |--------------------------------------------------------------------------
        */

        $taxAmountCents = (int) round(
            (float) $order->tax * 100,
        );

        if ($taxAmountCents < 0) {
            throw new RuntimeException(
                'Invalid tax amount.',
            );
        }

        if ($taxAmountCents > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Tax',
                    ],
                    'unit_amount' => $taxAmountCents,
                ],
                'quantity' => 1,
            ];

            $stripeTotalCents += $taxAmountCents;
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Line Items
        |--------------------------------------------------------------------------
        */

        if ($lineItems === []) {
            throw new RuntimeException(
                'Cannot create Stripe Checkout Session for an empty order.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Stripe Checkout Line Item Limit
        |--------------------------------------------------------------------------
        */

        if (count($lineItems) > 100) {
            throw new RuntimeException(
                'This order contains too many line items for Stripe Checkout.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Order Total
        |--------------------------------------------------------------------------
        */

        $orderTotalCents = (int) round(
            (float) $order->total * 100,
        );

        if ($orderTotalCents <= 0) {
            throw new RuntimeException(
                'Cannot create a Stripe Checkout Session for an order with no payable amount.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Exact Total Validation
        |--------------------------------------------------------------------------
        */

        if ($stripeTotalCents !== $orderTotalCents) {
            throw new RuntimeException(
                sprintf(
                    'Stripe amount does not match the order total. Stripe: %d cents, Order: %d cents.',
                    $stripeTotalCents,
                    $orderTotalCents,
                ),
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Idempotency Key
        |--------------------------------------------------------------------------
        |
        | A new Checkout Session request gets a unique idempotency key.
        |
        | Existing open sessions are reused above, so a unique key is only
        | needed when Stripe requires a new Checkout Session.
        |
        */

        $idempotencyKey = sprintf(
            'ecommerce-order-%d-%s',
            $order->id,
            bin2hex(random_bytes(16)),
        );

        /*
        |--------------------------------------------------------------------------
        | Create Checkout Session
        |--------------------------------------------------------------------------
        */

        $session = $stripe->checkout->sessions->create(
            [
                'mode' => 'payment',

                'line_items' => $lineItems,

                'customer_email' => $order->email,

                'client_reference_id' => (string) $order->id,

                'metadata' => [
                    'payment_type' => 'ecommerce',
                    'order_id' => (string) $order->id,
                ],

                'success_url' => route(
                        'checkout.success',
                    ) . '?session_id={CHECKOUT_SESSION_ID}',

                'cancel_url' => route(
                    'my-orders.show',
                    $order,
                ),

                'billing_address_collection' => 'auto',

                'phone_number_collection' => [
                    'enabled' => true,
                ],

                'submit_type' => 'pay',
            ],
            [
                'idempotency_key' => $idempotencyKey,
            ],
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Stripe Response
        |--------------------------------------------------------------------------
        */

        if (
            !is_string($session->id)
            || trim($session->id) === ''
            || !is_string($session->url)
            || trim($session->url) === ''
        ) {
            throw new RuntimeException(
                'Unable to create Stripe Checkout Session.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Store Stripe Session
        |--------------------------------------------------------------------------
        */

        $order->update([
            'payment_gateway' => 'stripe',
            'stripe_checkout_session_id' => $session->id,
        ]);

        return $session;
    }
}
