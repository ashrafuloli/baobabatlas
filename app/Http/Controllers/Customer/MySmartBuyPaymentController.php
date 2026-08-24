<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyPayment;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class MySmartBuyPaymentController extends Controller
{
    /**
     * Show payment page.
     */
    public function show(
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $smartBuy->load([

            'latestQuote',

            'quote',

            'payment',

        ]);


        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        if (!$quote) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'A quote is required before payment.'
                );

        }


        if (
            $smartBuy->status ===
            'payment_completed'
        ) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'success',
                    'This payment has already been completed.'
                );

        }


        if (
            !in_array(
                $smartBuy->status,
                [

                    'quote_accepted',

                    'payment_pending',

                ],
                true
            )
        ) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Payment is not available at this stage.'
                );

        }


        $payment =
            $smartBuy->payment;


        return view(
            'backend.pages.my-smart-buy.payment',
            compact(
                'smartBuy',
                'quote',
                'payment'
            )
        );
    }


    /**
     * Create Stripe Checkout Session.
     */
    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $smartBuy->load([

            'latestQuote',

            'quote',

            'payment',

        ]);


        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        if (!$quote) {

            return back()->with(
                'error',
                'Quote not found.'
            );

        }


        if (
            !in_array(
                $smartBuy->status,
                [

                    'quote_accepted',

                    'payment_pending',

                ],
                true
            )
        ) {

            return back()->with(
                'error',
                'Payment cannot be processed at this stage.'
            );

        }


        if (
            $smartBuy->payment
            &&
            $smartBuy->payment->isCompleted()
        ) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'success',
                    'This payment has already been completed.'
                );

        }


        $validated = $request->validate([

            'payment_method' => [

                'required',

                'string',

                'in:card',

            ],

        ]);


        $amount =
            (float)
            $quote->total_amount;


        if ($amount <= 0) {

            return back()->with(
                'error',
                'Invalid payment amount.'
            );

        }


        $currency =
            strtoupper(
                $quote->currency
                ?? 'USD'
            );


        /*
        |--------------------------------------------------------------------------
        | Create Or Update Payment Record
        |--------------------------------------------------------------------------
        */

        try {

            $payment =
                DB::transaction(
                    function () use (
                        $smartBuy,
                        $quote,
                        $validated,
                        $currency
                    ) {

                        $payment =
                            SmartBuyPayment::where(
                                'smart_buy_request_id',
                                $smartBuy->id
                            )
                                ->lockForUpdate()
                                ->first();


                        if ($payment) {

                            if (
                                $payment->isCompleted()
                            ) {

                                throw new \RuntimeException(
                                    'This payment has already been completed.'
                                );

                            }


                            $payment->update([

                                'smart_buy_quote_id' =>
                                    $quote->id,

                                'amount' =>
                                    $quote->total_amount,

                                'currency' =>
                                    $currency,

                                'payment_method' =>
                                    $validated[
                                    'payment_method'
                                    ],

                                'payment_gateway' =>
                                    'stripe',

                                'transaction_id' =>
                                    null,

                                'status' =>
                                    SmartBuyPayment::STATUS_PROCESSING,

                                'paid_at' =>
                                    null,

                            ]);

                        } else {

                            $payment =
                                SmartBuyPayment::create([

                                    'smart_buy_request_id' =>
                                        $smartBuy->id,

                                    'smart_buy_quote_id' =>
                                        $quote->id,

                                    'payment_number' =>
                                        $this->generatePaymentNumber(),

                                    'amount' =>
                                        $quote->total_amount,

                                    'currency' =>
                                        $currency,

                                    'payment_method' =>
                                        $validated[
                                        'payment_method'
                                        ],

                                    'payment_gateway' =>
                                        'stripe',

                                    'transaction_id' =>
                                        null,

                                    'status' =>
                                        SmartBuyPayment::STATUS_PROCESSING,

                                    'paid_at' =>
                                        null,

                                ]);

                        }


                        $smartBuy->update([

                            'status' =>
                                'payment_pending',

                        ]);


                        return $payment;

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Create Stripe Checkout Session
            |--------------------------------------------------------------------------
            */

            $stripeSecret =
                config(
                    'services.stripe.secret'
                );


            if (!$stripeSecret) {

                throw new \RuntimeException(
                    'Stripe secret key is not configured.'
                );

            }


            $stripe =
                new StripeClient(
                    $stripeSecret
                );


            $session =
                $stripe
                    ->checkout
                    ->sessions
                    ->create([

                        'mode' =>
                            'payment',


                        'payment_method_types' => [

                            'card',

                        ],


                        'customer_email' =>

                            auth()
                                ->user()
                                ?->email,


                        'client_reference_id' =>

                            (string)
                            $payment->id,


                        'metadata' => [

                            'payment_id' =>

                                (string)
                                $payment->id,


                            'smart_buy_id' =>

                                (string)
                                $smartBuy->id,


                            'quote_id' =>

                                (string)
                                $quote->id,


                            'payment_number' =>

                                $payment->payment_number,

                        ],


                        'line_items' => [

                            [

                                'price_data' => [

                                    'currency' =>
                                        strtolower(
                                            $currency
                                        ),


                                    'product_data' => [

                                        'name' =>

                                            'Smart Buy ' .

                                            $quote->quote_number,


                                        'description' =>

                                            'Payment for Smart Buy request ' .

                                            $smartBuy->request_number,

                                    ],


                                    'unit_amount' =>

                                        (int)
                                        round(
                                            $amount * 100
                                        ),

                                ],


                                'quantity' =>
                                    1,

                            ],

                        ],


                        'success_url' =>

                            route(
                                'my-smart-buy.payment.success',
                                $smartBuy->id
                            )

                            .

                            '?session_id={CHECKOUT_SESSION_ID}',


                        'cancel_url' =>

                            route(
                                'my-smart-buy.payment.cancel',
                                $smartBuy->id
                            ),

                    ]);


            /*
            |--------------------------------------------------------------------------
            | Save Stripe Session ID
            |--------------------------------------------------------------------------
            */

            $payment->update([

                'transaction_id' =>
                    $session->id,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Redirect To Stripe Checkout
            |--------------------------------------------------------------------------
            */

            return redirect()->away(
                $session->url
            );

        } catch (
        \Throwable $exception
        ) {

            report(
                $exception
            );


            /*
            |--------------------------------------------------------------------------
            | Reset Payment For Retry
            |--------------------------------------------------------------------------
            */

            if (
                isset($payment)
                &&
                $payment
                &&
                !$payment->isCompleted()
            ) {

                $payment->update([

                    'status' =>
                        SmartBuyPayment::STATUS_FAILED,

                ]);

            }


            if (
                $smartBuy->status !==
                'payment_completed'
            ) {

                $smartBuy->update([

                    'status' =>
                        'payment_pending',

                ]);

            }


            return back()->with(
                'error',
                'Unable to start the payment process. Please try again.'
            );

        }
    }


    /**
     * Stripe payment success return.
     *
     * Webhook should remain the primary confirmation source.
     */
    public function success(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $sessionId =
            $request->query(
                'session_id'
            );


        if (!$sessionId) {

            return redirect()
                ->route(
                    'my-smart-buy.payment',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Payment session could not be verified.'
                );

        }


        $smartBuy->load([

            'payment',

        ]);


        $payment =
            $smartBuy->payment;


        if (!$payment) {

            return redirect()
                ->route(
                    'my-smart-buy.payment.success',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Payment record not found.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Already Completed
        |--------------------------------------------------------------------------
        */

        if (
            $payment->isCompleted()
        ) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'success',
                    'Payment completed successfully.'
                );

        }


        try {

            $stripeSecret =
                config(
                    'services.stripe.secret'
                );


            if (!$stripeSecret) {

                throw new \RuntimeException(
                    'Stripe secret key is not configured.'
                );

            }


            $stripe =
                new StripeClient(
                    $stripeSecret
                );


            $session =
                $stripe
                    ->checkout
                    ->sessions
                    ->retrieve(
                        $sessionId
                    );


            /*
            |--------------------------------------------------------------------------
            | Security Checks
            |--------------------------------------------------------------------------
            */

            if (
                $payment->transaction_id !==
                $session->id
            ) {

                abort(403);

            }


            if (
                (string)
                (
                    $session->metadata->payment_id
                    ?? ''
                )
                !==
                (string)
                $payment->id
            ) {

                abort(403);

            }


            if (
                (string)
                (
                    $session->metadata->smart_buy_id
                    ?? ''
                )
                !==
                (string)
                $smartBuy->id
            ) {

                abort(403);

            }


            /*
            |--------------------------------------------------------------------------
            | Payment Completed
            |--------------------------------------------------------------------------
            */

            if (
                $session->payment_status ===
                'paid'
            ) {

                DB::transaction(
                    function () use (
                        $payment,
                        $smartBuy,
                        $session
                    ) {

                        $payment->refresh();


                        if (
                            !$payment->isCompleted()
                        ) {

                            $payment->update([

                                'status' =>
                                    SmartBuyPayment::STATUS_COMPLETED,

                                'paid_at' =>
                                    now(),

                                'transaction_id' =>
                                    $session->id,

                            ]);

                        }


                        if (
                            $smartBuy->status !==
                            'payment_completed'
                        ) {

                            $smartBuy->update([

                                'status' =>
                                    'payment_completed',

                            ]);

                        }

                    }
                );


                return redirect()
                    ->route(
                        'my-smart-buy.details',
                        $smartBuy->id
                    )
                    ->with(
                        'success',
                        'Payment completed successfully.'
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Payment Not Completed Yet
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'my-smart-buy.payment',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Your payment is still being processed.'
                );

        } catch (
        \Throwable $exception
        ) {

            report(
                $exception
            );


            return redirect()
                ->route(
                    'smart-buy-payment',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Unable to verify the payment.'
                );

        }
    }


    /**
     * Stripe payment cancelled.
     */
    public function cancel(
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $payment =
            $smartBuy->payment;


        /*
        |--------------------------------------------------------------------------
        | Reset Payment Status
        |--------------------------------------------------------------------------
        */

        if (
            $payment
            &&
            !$payment->isCompleted()
        ) {

            $payment->update([

                'status' =>
                    SmartBuyPayment::STATUS_PENDING,

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Keep Smart Buy Available For Retry
        |--------------------------------------------------------------------------
        */

        if (
            $smartBuy->status !==
            'payment_completed'
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_pending',

            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Redirect Back To Payment Page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'my-smart-buy.payment',
                $smartBuy->id
            )
            ->with(
                'error',
                'Payment was cancelled. You can try again.'
            );
    }


    /**
     * Payment failed.
     */
    public function failed(
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $payment =
            $smartBuy->payment;


        if (
            $payment
            &&
            !$payment->isCompleted()
        ) {

            $payment->update([

                'status' =>
                    SmartBuyPayment::STATUS_FAILED,

            ]);

        }


        if (
            $smartBuy->status !==
            'payment_completed'
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_pending',

            ]);

        }


        return redirect()
            ->route(
                'my-smart-buy.payment',
                $smartBuy->id
            )
            ->with(
                'error',
                'Payment failed. Please try again.'
            );
    }


    /**
     * Generate Unique Payment Number.
     */
    private function generatePaymentNumber(): string
    {
        do {

            $paymentNumber =

                'SBP-' .

                strtoupper(
                    Str::random(10)
                );

        } while (

            SmartBuyPayment::where(
                'payment_number',
                $paymentNumber
            )->exists()

        );


        return $paymentNumber;
    }
}
