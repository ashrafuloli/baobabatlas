<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyPayment;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartBuyPaymentController extends Controller
{
    /**
     * Store or update payment.
     */
    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        $validated = $request->validate([

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:255',
            ],

            'transaction_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:pending,paid,failed,refunded',
            ],

            'paid_at' => [
                'nullable',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ]);


        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        if (!$quote) {

            return back()->with(
                'error',
                'A quote must be created before recording a payment.'
            );

        }


        DB::transaction(
            function () use (
                $smartBuy,
                $quote,
                $validated
            ) {

                $payment =
                    $smartBuy
                        ->payment()
                        ->first();


                if ($payment) {

                    $payment->update([

                        'smart_buy_quote_id' =>
                            $quote->id,

                        'amount' =>
                            $validated['amount'],

                        'currency' =>
                            $quote->currency,

                        'payment_method' =>
                            $validated['payment_method'],

                        'transaction_id' =>
                            $validated[
                            'transaction_id'
                            ] ?? null,

                        'status' =>
                            $validated['status'],

                        'paid_at' =>
                            $validated[
                            'paid_at'
                            ] ?? null,

                        'notes' =>
                            $validated[
                            'notes'
                            ] ?? null,

                    ]);

                } else {

                    $payment =
                        $smartBuy
                            ->payment()
                            ->create([

                                'smart_buy_quote_id' =>
                                    $quote->id,

                                'payment_number' =>
                                    $this->generatePaymentNumber(),

                                'amount' =>
                                    $validated['amount'],

                                'currency' =>
                                    $quote->currency,

                                'payment_method' =>
                                    $validated[
                                    'payment_method'
                                    ],

                                'transaction_id' =>
                                    $validated[
                                    'transaction_id'
                                    ] ?? null,

                                'status' =>
                                    $validated['status'],

                                'paid_at' =>
                                    $validated[
                                    'paid_at'
                                    ] ?? null,

                                'notes' =>
                                    $validated[
                                    'notes'
                                    ] ?? null,

                            ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Update Request Status
                |--------------------------------------------------------------------------
                */

                if (
                    $payment->status === 'paid'
                ) {

                    $smartBuy->update([

                        'status' =>
                            'payment_completed',

                    ]);

                }

            }
        );


        return back()->with(
            'success',
            'Payment information saved successfully.'
        );
    }


    /**
     * Update payment.
     */
    public function update(
        Request $request,
        SmartBuyPayment $payment
    ) {
        $validated = $request->validate([

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:255',
            ],

            'transaction_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:pending,paid,failed,refunded',
            ],

            'paid_at' => [
                'nullable',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ]);


        DB::transaction(
            function () use (
                $payment,
                $validated
            ) {

                $payment->update(
                    $validated
                );


                $smartBuy =
                    $payment
                        ->smartBuyRequest;


                if (
                    $payment->status === 'paid'
                ) {

                    $smartBuy->update([

                        'status' =>
                            'payment_completed',

                    ]);

                }

            }
        );


        return back()->with(
            'success',
            'Payment updated successfully.'
        );
    }


    /**
     * Generate payment number.
     */
    private function generatePaymentNumber(): string
    {
        $lastPayment =
            SmartBuyPayment::latest(
                'id'
            )
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
