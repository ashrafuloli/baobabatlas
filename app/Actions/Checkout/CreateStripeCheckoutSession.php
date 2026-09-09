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

        if ($order->isPaid()) {
            throw new RuntimeException(
                'A Checkout Session cannot be created for a paid order.',
            );
        }

        if ($order->isCancelled()) {
            throw new RuntimeException(
                'A Checkout Session cannot be created for a cancelled order.',
            );
        }

        if ($order->status === Order::STATUS_FAILED) {
            throw new RuntimeException(
                'A Checkout Session cannot be created for a failed order.',
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
                    ?: 'usd'
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
        | Validate Order Items
        |--------------------------------------------------------------------------
        */

        if ($order->items->isEmpty()) {
            throw new RuntimeException(
                'Cannot create Stripe Checkout Session for an empty order.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Build Stripe Line Items
        |--------------------------------------------------------------------------
        |
        | line_total is the authoritative amount.
        |
        | We split an item into a maximum of two Stripe line items when
        | quantity does not divide evenly into cents.
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

            if ($lineTotalCents === 0) {
                continue;
            }

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
                'Stripe amount does not match the order total.',
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Idempotency Key
        |--------------------------------------------------------------------------
        */

        if ($existingSessionId !== '') {
            $idempotencyKey = sprintf(
                'ecommerce-order-%d-retry-%s',
                $order->id,
                substr(
                    hash(
                        'sha256',
                        $existingSessionId,
                    ),
                    0,
                    16,
                ),
            );
        } else {
            $idempotencyKey = sprintf(
                'ecommerce-order-%d-initial',
                $order->id,
            );
        }

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
                    'checkout',
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
