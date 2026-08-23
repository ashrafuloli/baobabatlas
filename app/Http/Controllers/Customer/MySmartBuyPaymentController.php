<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyPayment;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    'my-smart-buy-details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'A quote is required before payment.'
                );

        }


        if (
            $smartBuy->status !== 'quote_accepted'
            &&
            $smartBuy->status !== 'payment_pending'
        ) {

            if (
                $smartBuy->status === 'payment_completed'
            ) {

                return redirect()
                    ->route(
                        'my-smart-buy-details',
                        $smartBuy->id
                    );

            }


            return redirect()
                ->route(
                    'my-smart-buy-details',
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
     * Create payment record.
     *
     * Gateway integration can be connected here.
     */
    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


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
                ]
            )
        ) {

            return back()->with(
                'error',
                'Payment cannot be created at this stage.'
            );

        }


        $validated = $request->validate([

            'payment_method' => [
                'required',
                'string',
                'max:255',
            ],

        ]);


        $payment =
            DB::transaction(
                function () use (
                    $smartBuy,
                    $quote,
                    $validated
                ) {

                    $payment =
                        $smartBuy
                            ->payment()
                            ->updateOrCreate(
                                [],

                                [

                                    'smart_buy_quote_id' =>
                                        $quote->id,

                                    'payment_number' =>
                                        $this->generatePaymentNumber(),

                                    'amount' =>
                                        $quote->total_amount,

                                    'currency' =>
                                        $quote->currency,

                                    'payment_method' =>
                                        $validated[
                                        'payment_method'
                                        ],

                                    'status' =>
                                        'pending',

                                ]
                            );


                    $smartBuy->update([

                        'status' =>
                            'payment_pending',

                    ]);


                    return $payment;

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Redirect To Payment Gateway
        |--------------------------------------------------------------------------
        */

        /*
         * Replace this section with your
         * Stripe / SSLCommerz / PayPal integration.
         */

        return redirect()
            ->route(
                'payments-smart-buy',
                [
                    'payment' =>
                        $payment->id,
                ]
            );
    }


    /**
     * Mark payment as successful.
     *
     * Call this from payment gateway callback.
     */
    public function success(
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $payment =
            $smartBuy->payment;


        if (!$payment) {

            return redirect()
                ->route(
                    'my-smart-buy-details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Payment record not found.'
                );

        }


        DB::transaction(
            function () use (
                $payment,
                $smartBuy
            ) {

                $payment->update([

                    'status' =>
                        'paid',

                    'paid_at' =>
                        now(),

                ]);


                $smartBuy->update([

                    'status' =>
                        'payment_completed',

                ]);

            }
        );


        return redirect()
            ->route(
                'my-smart-buy-details',
                $smartBuy->id
            )
            ->with(
                'success',
                'Payment completed successfully.'
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


        if ($payment) {

            $payment->update([

                'status' =>
                    'failed',

            ]);

        }


        $smartBuy->update([

            'status' =>
                'payment_pending',

        ]);


        return redirect()
            ->route(
                'smart-buy-payment',
                $smartBuy->id
            )
            ->with(
                'error',
                'Payment failed. Please try again.'
            );
    }


    /**
     * Generate unique payment number.
     */
    private function generatePaymentNumber(): string
    {
        $lastPayment =
            SmartBuyPayment::latest('id')
                ->lockForUpdate()
                ->first();


        $nextId =
            $lastPayment
                ? $lastPayment->id + 1
                : 1;


        return 'SBP-' . str_pad(
                $nextId,
                6,
                '0',
                STR_PAD_LEFT
            );
    }
}
