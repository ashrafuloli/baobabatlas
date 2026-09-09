<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Order\CompleteOrder;
use App\Models\Order;
use App\Models\SmartBuyPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

final class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe Webhook.
     */
    public function handle(Request $request)
    {
        $payload = $request->getContent();

        $signature = $request->header(
            'Stripe-Signature',
        );

        $webhookSecret = config(
            'services.stripe.webhook_secret',
        );

        if (!$webhookSecret) {
            Log::error(
                'Stripe webhook secret is not configured.',
            );

            return response(
                'Webhook secret not configured.',
                500,
            );
        }

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret,
            );
        } catch (\UnexpectedValueException $exception) {
            Log::warning(
                'Invalid Stripe webhook payload.',
            );

            return response(
                'Invalid payload.',
                400,
            );
        } catch (SignatureVerificationException $exception) {
            Log::warning(
                'Invalid Stripe webhook signature.',
            );

            return response(
                'Invalid signature.',
                400,
            );
        }

        Log::info(
            'Stripe webhook event received.',
            [
                'event_id' => $event->id ?? null,
                'event_type' => $event->type,
            ],
        );

        /*
        |--------------------------------------------------------------------------
        | Handle Stripe Events
        |--------------------------------------------------------------------------
        */

        switch ($event->type) {
            case 'checkout.session.completed':
            case 'checkout.session.async_payment_succeeded':
                $this->handleCheckoutCompleted(
                    $event->data->object,
                );

                break;

            case 'checkout.session.async_payment_failed':
                $this->handleCheckoutFailed(
                    $event->data->object,
                );

                break;

            case 'checkout.session.expired':
                $this->handleCheckoutExpired(
                    $event->data->object,
                );

                break;
        }

        return response(
            'Webhook received.',
            200,
        );
    }

    /**
     * Route the successful checkout to the correct application flow.
     */
    private function handleCheckoutCompleted(
        object $session,
    ): void {
        Log::info(
            'Stripe checkout completion received.',
            [
                'session_id' => $session->id ?? null,
                'payment_status' =>
                    $session->payment_status ?? null,
                'payment_intent' =>
                    $session->payment_intent ?? null,
                'payment_type' =>
                    $session->metadata->payment_type ?? null,
                'order_id' =>
                    $session->metadata->order_id ?? null,
                'payment_id' =>
                    $session->metadata->payment_id ?? null,
            ],
        );

        /*
        |--------------------------------------------------------------------------
        | Verify Paid Status
        |--------------------------------------------------------------------------
        */

        if (
            ($session->payment_status ?? null)
            !== 'paid'
        ) {
            Log::warning(
                'Stripe checkout completion skipped because payment is not paid.',
                [
                    'session_id' => $session->id ?? null,
                    'payment_status' =>
                        $session->payment_status ?? null,
                    'payment_type' =>
                        $session->metadata->payment_type ?? null,
                ],
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Ecommerce
        |--------------------------------------------------------------------------
        */

        if ($this->isEcommerceCheckout($session)) {
            Log::info(
                'Stripe ecommerce checkout detected.',
                [
                    'session_id' => $session->id ?? null,
                    'order_id' =>
                        $session->metadata->order_id ?? null,
                ],
            );

            $this->handleEcommerceCheckoutCompleted(
                $session,
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Smart Buy
        |--------------------------------------------------------------------------
        */

        Log::info(
            'Stripe checkout routed to Smart Buy flow.',
            [
                'session_id' => $session->id ?? null,
                'payment_id' =>
                    $session->metadata->payment_id ?? null,
            ],
        );

        $this->handleSmartBuyCheckoutCompleted(
            $session,
        );
    }

    /**
     * Handle successful ecommerce checkout.
     */
    private function handleEcommerceCheckoutCompleted(
        object $session,
    ): void {
        $orderId = $session->metadata->order_id ?? null;

        if (!$orderId) {
            Log::warning(
                'Stripe ecommerce order ID missing from metadata.',
                [
                    'session_id' => $session->id ?? null,
                    'metadata' =>
                        $session->metadata->toArray(),
                ],
            );

            return;
        }

        $order = Order::query()
            ->whereKey((int) $orderId)
            ->first();

        if ($order === null) {
            Log::warning(
                'Ecommerce order not found for Stripe checkout.',
                [
                    'order_id' => $orderId,
                    'session_id' => $session->id ?? null,
                ],
            );

            return;
        }

        Log::info(
            'Ecommerce order found for Stripe checkout.',
            [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' =>
                    $order->payment_status,
                'stored_session_id' =>
                    $order->stripe_checkout_session_id,
                'stripe_session_id' =>
                    $session->id ?? null,
            ],
        );

        /*
        |--------------------------------------------------------------------------
        | Verify Stripe Session
        |--------------------------------------------------------------------------
        */

        if (
            $order->stripe_checkout_session_id !== null
            && $order->stripe_checkout_session_id
            !== $session->id
        ) {
            Log::warning(
                'Stripe session ID does not match ecommerce order.',
                [
                    'order_id' => $order->id,
                    'stored_session_id' =>
                        $order->stripe_checkout_session_id,
                    'stripe_session_id' =>
                        $session->id ?? null,
                ],
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Complete Order
        |--------------------------------------------------------------------------
        */

        try {
            Log::info(
                'Starting ecommerce CompleteOrder.',
                [
                    'order_id' => $order->id,
                    'order_number' =>
                        $order->order_number,
                    'session_id' =>
                        $session->id ?? null,
                    'payment_intent' =>
                        $session->payment_intent ?? null,
                ],
            );

            app(CompleteOrder::class)->execute(
                $order,
                $session->id ?? null,
                $session->payment_intent ?? null,
            );

            Log::info(
                'Ecommerce CompleteOrder finished.',
                [
                    'order_id' => $order->id,
                    'order_number' =>
                        $order->order_number,
                    'session_id' =>
                        $session->id ?? null,
                ],
            );
        } catch (\Throwable $exception) {
            Log::error(
                'Unable to complete ecommerce order after Stripe payment.',
                [
                    'order_id' => $order->id,
                    'order_number' =>
                        $order->order_number,
                    'session_id' =>
                        $session->id ?? null,
                    'payment_intent' =>
                        $session->payment_intent ?? null,
                    'exception' =>
                        $exception::class,
                    'error' =>
                        $exception->getMessage(),
                    'trace' =>
                        $exception->getTraceAsString(),
                ],
            );

            /*
            |--------------------------------------------------------------------------
            | Do Not Acknowledge Failed Completion
            |--------------------------------------------------------------------------
            */

            throw $exception;
        }
    }

    /**
     * Handle successful existing Smart Buy checkout.
     */
    private function handleSmartBuyCheckoutCompleted(
        object $session,
    ): void {
        $paymentId = $session->metadata->payment_id ?? null;

        if (!$paymentId) {
            Log::warning(
                'Stripe payment ID missing from metadata.',
                [
                    'session_id' => $session->id ?? null,
                ],
            );

            return;
        }

        DB::transaction(
            function () use (
                $paymentId,
                $session,
            ): void {
                $payment = SmartBuyPayment::with(
                    'smartBuyRequest',
                )
                    ->lockForUpdate()
                    ->find($paymentId);

                if (!$payment) {
                    Log::warning(
                        'Smart Buy payment not found.',
                        [
                            'payment_id' => $paymentId,
                        ],
                    );

                    return;
                }

                if (
                    $payment->transaction_id
                    && $payment->transaction_id !== $session->id
                ) {
                    Log::warning(
                        'Stripe session ID does not match payment.',
                        [
                            'payment_id' => $payment->id,
                            'stored_session_id' =>
                                $payment->transaction_id,
                            'stripe_session_id' =>
                                $session->id,
                        ],
                    );

                    return;
                }

                if ($payment->isCompleted()) {
                    return;
                }

                $payment->update([
                    'payment_gateway' => 'stripe',
                    'payment_method' => 'card',
                    'transaction_id' => $session->id,
                    'status' =>
                        SmartBuyPayment::STATUS_COMPLETED,
                    'paid_at' => now(),
                ]);

                if ($payment->smartBuyRequest) {
                    $payment->smartBuyRequest->update([
                        'status' => 'payment_completed',
                    ]);
                }
            },
        );
    }

    /**
     * Handle failed checkout.
     */
    private function handleCheckoutFailed(
        object $session,
    ): void {
        if ($this->isEcommerceCheckout($session)) {
            $this->handleEcommerceCheckoutFailed(
                $session,
            );

            return;
        }

        $paymentId = $session->metadata->payment_id ?? null;

        if (!$paymentId) {
            return;
        }

        DB::transaction(
            function () use ($paymentId): void {
                $payment = SmartBuyPayment::with(
                    'smartBuyRequest',
                )
                    ->lockForUpdate()
                    ->find($paymentId);

                if (
                    !$payment
                    || $payment->isCompleted()
                ) {
                    return;
                }

                $payment->update([
                    'status' =>
                        SmartBuyPayment::STATUS_FAILED,
                ]);

                if ($payment->smartBuyRequest) {
                    $payment->smartBuyRequest->update([
                        'status' => 'payment_pending',
                    ]);
                }
            },
        );
    }

    /**
     * Handle failed ecommerce checkout.
     */
    private function handleEcommerceCheckoutFailed(
        object $session,
    ): void {
        $orderId = $session->metadata->order_id ?? null;

        if (!$orderId) {
            return;
        }

        DB::transaction(
            function () use ($orderId, $session): void {
                $order = Order::query()
                    ->lockForUpdate()
                    ->find((int) $orderId);

                if ($order === null) {
                    Log::warning(
                        'Ecommerce order not found for failed Stripe checkout.',
                        [
                            'order_id' => $orderId,
                            'session_id' =>
                                $session->id ?? null,
                        ],
                    );

                    return;
                }

                if (
                    $order->stripe_checkout_session_id !== null
                    && $order->stripe_checkout_session_id
                    !== $session->id
                ) {
                    Log::warning(
                        'Stripe session ID does not match ecommerce order.',
                        [
                            'order_id' => $order->id,
                            'stored_session_id' =>
                                $order->stripe_checkout_session_id,
                            'stripe_session_id' =>
                                $session->id ?? null,
                        ],
                    );

                    return;
                }

                if ($order->isPaid()) {
                    return;
                }

                $order->update([
                    'status' => Order::STATUS_FAILED,
                    'payment_status' =>
                        Order::PAYMENT_STATUS_FAILED,
                ]);
            },
        );
    }

    /**
     * Handle expired checkout.
     */
    private function handleCheckoutExpired(
        object $session,
    ): void {
        if ($this->isEcommerceCheckout($session)) {
            $this->handleEcommerceCheckoutExpired(
                $session,
            );

            return;
        }

        $paymentId = $session->metadata->payment_id ?? null;

        if (!$paymentId) {
            return;
        }

        DB::transaction(
            function () use ($paymentId): void {
                $payment = SmartBuyPayment::with(
                    'smartBuyRequest',
                )
                    ->lockForUpdate()
                    ->find($paymentId);

                if (
                    !$payment
                    || $payment->isCompleted()
                ) {
                    return;
                }

                $payment->update([
                    'status' =>
                        SmartBuyPayment::STATUS_PENDING,
                ]);

                if ($payment->smartBuyRequest) {
                    $payment->smartBuyRequest->update([
                        'status' => 'payment_pending',
                    ]);
                }
            },
        );
    }

    /**
     * Handle expired ecommerce checkout.
     */
    private function handleEcommerceCheckoutExpired(
        object $session,
    ): void {
        $orderId = $session->metadata->order_id ?? null;

        if (!$orderId) {
            return;
        }

        DB::transaction(
            function () use ($orderId, $session): void {
                $order = Order::query()
                    ->lockForUpdate()
                    ->find((int) $orderId);

                if ($order === null) {
                    return;
                }

                if (
                    $order->stripe_checkout_session_id !== null
                    && $order->stripe_checkout_session_id
                    !== $session->id
                ) {
                    Log::warning(
                        'Stripe session ID does not match ecommerce order.',
                        [
                            'order_id' => $order->id,
                            'stored_session_id' =>
                                $order->stripe_checkout_session_id,
                            'stripe_session_id' =>
                                $session->id ?? null,
                        ],
                    );

                    return;
                }

                if ($order->isPaid()) {
                    return;
                }

                $order->update([
                    'status' => Order::STATUS_CANCELLED,
                    'payment_status' =>
                        Order::PAYMENT_STATUS_PENDING,
                ]);
            },
        );
    }

    /**
     * Determine whether a Stripe Checkout Session belongs to ecommerce.
     */
    private function isEcommerceCheckout(
        object $session,
    ): bool {
        return (
            ($session->metadata->payment_type ?? null)
            === 'ecommerce'
        );
    }
}
