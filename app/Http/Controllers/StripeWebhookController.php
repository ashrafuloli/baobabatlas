<?php

namespace App\Http\Controllers;

use App\Models\SmartBuyPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    /**
     * Handle Stripe Webhook.
     */
    public function handle(
        Request $request
    ) {
        $payload =
            $request->getContent();


        $signature =
            $request->header(
                'Stripe-Signature'
            );


        $webhookSecret =
            config(
                'services.stripe.webhook_secret'
            );


        if (!$webhookSecret) {

            Log::error(
                'Stripe webhook secret is not configured.'
            );


            return response(
                'Webhook secret not configured.',
                500
            );

        }


        try {

            $event =
                Webhook::constructEvent(

                    $payload,

                    $signature,

                    $webhookSecret

                );

        } catch (
        \UnexpectedValueException
        $exception
        ) {

            Log::warning(
                'Invalid Stripe webhook payload.'
            );


            return response(
                'Invalid payload.',
                400
            );

        } catch (
        SignatureVerificationException
        $exception
        ) {

            Log::warning(
                'Invalid Stripe webhook signature.'
            );


            return response(
                'Invalid signature.',
                400
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Handle Stripe Events
        |--------------------------------------------------------------------------
        */

        switch (
        $event->type
        ) {

            /*
            |--------------------------------------------------------------------------
            | Checkout Completed
            |--------------------------------------------------------------------------
            */

            case 'checkout.session.completed':

                $session =
                    $event
                        ->data
                        ->object;


                $this->handleCheckoutCompleted(
                    $session
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | Checkout Async Payment Succeeded
            |--------------------------------------------------------------------------
            */

            case 'checkout.session.async_payment_succeeded':

                $session =
                    $event
                        ->data
                        ->object;


                $this->handleCheckoutCompleted(
                    $session
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | Checkout Async Payment Failed
            |--------------------------------------------------------------------------
            */

            case 'checkout.session.async_payment_failed':

                $session =
                    $event
                        ->data
                        ->object;


                $this->handleCheckoutFailed(
                    $session
                );

                break;


            /*
            |--------------------------------------------------------------------------
            | Checkout Expired
            |--------------------------------------------------------------------------
            */

            case 'checkout.session.expired':

                $session =
                    $event
                        ->data
                        ->object;


                $this->handleCheckoutExpired(
                    $session
                );

                break;

        }


        return response(
            'Webhook received.',
            200
        );
    }


    /**
     * Handle Successful Checkout.
     */
    private function handleCheckoutCompleted(
        object $session
    ): void {
        if (
            ($session->payment_status ?? null)
            !== 'paid'
        ) {

            return;

        }


        $paymentId =

            $session
                ->metadata
                ->payment_id
            ?? null;


        if (!$paymentId) {

            Log::warning(
                'Stripe payment ID missing from metadata.',
                [

                    'session_id' =>
                        $session->id
                        ?? null,

                ]
            );


            return;

        }


        DB::transaction(
            function () use (
                $paymentId,
                $session
            ) {

                $payment =
                    SmartBuyPayment::with(
                        'smartBuyRequest'
                    )
                        ->lockForUpdate()
                        ->find(
                            $paymentId
                        );


                if (!$payment) {

                    Log::warning(
                        'Smart Buy payment not found.',
                        [

                            'payment_id' =>
                                $paymentId,

                        ]
                    );


                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Verify Session ID
                |--------------------------------------------------------------------------
                */

                if (
                    $payment->transaction_id
                    &&
                    $payment->transaction_id !==
                    $session->id
                ) {

                    Log::warning(
                        'Stripe session ID does not match payment.',
                        [

                            'payment_id' =>
                                $payment->id,

                            'stored_session_id' =>
                                $payment->transaction_id,

                            'stripe_session_id' =>
                                $session->id,

                        ]
                    );


                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Already Completed
                |--------------------------------------------------------------------------
                */

                if (
                    $payment->isCompleted()
                ) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Mark Payment Completed
                |--------------------------------------------------------------------------
                */

                $payment->update([

                    'payment_gateway' =>
                        'stripe',

                    'payment_method' =>
                        'card',

                    'transaction_id' =>
                        $session->id,

                    'status' =>
                        SmartBuyPayment::STATUS_COMPLETED,

                    'paid_at' =>
                        now(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy Status
                |--------------------------------------------------------------------------
                */

                if (
                    $payment->smartBuyRequest
                ) {

                    $payment
                        ->smartBuyRequest
                        ->update([

                            'status' =>
                                'payment_completed',

                        ]);

                }

            }
        );
    }


    /**
     * Handle Failed Checkout.
     */
    private function handleCheckoutFailed(
        object $session
    ): void {
        $paymentId =

            $session
                ->metadata
                ->payment_id
            ?? null;


        if (!$paymentId) {

            return;

        }


        DB::transaction(
            function () use (
                $paymentId
            ) {

                $payment =
                    SmartBuyPayment::with(
                        'smartBuyRequest'
                    )
                        ->lockForUpdate()
                        ->find(
                            $paymentId
                        );


                if (
                    !$payment
                    ||
                    $payment->isCompleted()
                ) {

                    return;

                }


                $payment->update([

                    'status' =>
                        SmartBuyPayment::STATUS_FAILED,

                ]);


                if (
                    $payment->smartBuyRequest
                ) {

                    $payment
                        ->smartBuyRequest
                        ->update([

                            'status' =>
                                'payment_pending',

                        ]);

                }

            }
        );
    }


    /**
     * Handle Expired Checkout Session.
     */
    private function handleCheckoutExpired(
        object $session
    ): void {
        $paymentId =

            $session
                ->metadata
                ->payment_id
            ?? null;


        if (!$paymentId) {

            return;

        }


        DB::transaction(
            function () use (
                $paymentId
            ) {

                $payment =
                    SmartBuyPayment::with(
                        'smartBuyRequest'
                    )
                        ->lockForUpdate()
                        ->find(
                            $paymentId
                        );


                if (
                    !$payment
                    ||
                    $payment->isCompleted()
                ) {

                    return;

                }


                $payment->update([

                    'status' =>
                        SmartBuyPayment::STATUS_PENDING,

                ]);


                if (
                    $payment->smartBuyRequest
                ) {

                    $payment
                        ->smartBuyRequest
                        ->update([

                            'status' =>
                                'payment_pending',

                        ]);

                }

            }
        );
    }
}
