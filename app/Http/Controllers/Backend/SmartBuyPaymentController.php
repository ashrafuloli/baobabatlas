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
     * Store a manual payment
     * or update an existing payment.
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

            'payment_gateway' => [
                'nullable',
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
                'in:pending,processing,completed,failed,cancelled,refunded',
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


        /*
        |--------------------------------------------------------------------------
        | Load Quote
        |--------------------------------------------------------------------------
        */

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
                'A quote must be created before recording a payment.'
            );

        }


        DB::transaction(
            function () use (
                $smartBuy,
                $quote,
                $validated
            ) {

                /*
                |--------------------------------------------------------------------------
                | Find Existing Payment
                |--------------------------------------------------------------------------
                */

                $payment =
                    $smartBuy->payment;


                /*
                |--------------------------------------------------------------------------
                | Payment Data
                |--------------------------------------------------------------------------
                */

                $paymentData = [

                    'smart_buy_quote_id' =>
                        $quote->id,

                    'amount' =>
                        $validated['amount'],

                    'currency' =>
                        $quote->currency,

                    'payment_method' =>
                        $validated['payment_method'],

                    'payment_gateway' =>
                        $validated[
                        'payment_gateway'
                        ] ?? null,

                    'transaction_id' =>
                        $validated[
                        'transaction_id'
                        ] ?? null,

                    'status' =>
                        $validated['status'],

                    'paid_at' =>
                        $this->resolvePaidAt(
                            $validated
                        ),

                    'notes' =>
                        $validated[
                        'notes'
                        ] ?? null,

                ];


                /*
                |--------------------------------------------------------------------------
                | Update Existing Payment
                |--------------------------------------------------------------------------
                */

                if ($payment) {

                    $payment->update(
                        $paymentData
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Create New Payment
                |--------------------------------------------------------------------------
                */

                else {

                    $payment =
                        $smartBuy
                            ->payment()
                            ->create(
                                array_merge(
                                    $paymentData,
                                    [

                                        'payment_number' =>
                                            $this->generatePaymentNumber(),

                                    ]
                                )
                            );

                }


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy Status
                |--------------------------------------------------------------------------
                */

                $this->syncSmartBuyStatus(
                    $smartBuy,
                    $payment
                );

            }
        );


        return back()->with(
            'success',
            'Payment information saved successfully.'
        );
    }


    /**
     * Update existing payment.
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

            'payment_gateway' => [
                'nullable',
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
                'in:pending,processing,completed,failed,cancelled,refunded',
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

                /*
                |--------------------------------------------------------------------------
                | Update Payment
                |--------------------------------------------------------------------------
                */

                $payment->update([

                    'amount' =>
                        $validated['amount'],

                    'payment_method' =>
                        $validated['payment_method'],

                    'payment_gateway' =>
                        $validated[
                        'payment_gateway'
                        ] ?? null,

                    'transaction_id' =>
                        $validated[
                        'transaction_id'
                        ] ?? null,

                    'status' =>
                        $validated['status'],

                    'paid_at' =>
                        $this->resolvePaidAt(
                            $validated,
                            $payment
                        ),

                    'notes' =>
                        $validated[
                        'notes'
                        ] ?? null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Load Smart Buy Request
                |--------------------------------------------------------------------------
                */

                $smartBuy =
                    $payment
                        ->smartBuyRequest;


                /*
                |--------------------------------------------------------------------------
                | Sync Smart Buy Status
                |--------------------------------------------------------------------------
                */

                if ($smartBuy) {

                    $this->syncSmartBuyStatus(
                        $smartBuy,
                        $payment
                    );

                }

            }
        );


        return back()->with(
            'success',
            'Payment updated successfully.'
        );
    }


    /**
     * Resolve Paid At Date
     */
    private function resolvePaidAt(
        array $validated,
        ?SmartBuyPayment $payment = null
    ) {
        /*
        |--------------------------------------------------------------------------
        | Completed Payment
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status']
            === SmartBuyPayment::STATUS_COMPLETED
        ) {

            if (
                !empty(
                $validated['paid_at']
                )
            ) {

                return
                    $validated['paid_at'];

            }


            if (
                $payment
                &&
                $payment->paid_at
            ) {

                return
                    $payment->paid_at;

            }


            return now();

        }


        /*
        |--------------------------------------------------------------------------
        | Other Payment Status
        |--------------------------------------------------------------------------
        */

        return
            $validated['paid_at']
            ?? null;
    }


    /**
     * Sync Smart Buy Request Status
     */
    private function syncSmartBuyStatus(
        SmartBuyRequest $smartBuy,
        SmartBuyPayment $payment
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Payment Completed
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_COMPLETED
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_completed',

            ]);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Processing
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_PROCESSING
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_processing',

            ]);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Pending
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_PENDING
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_pending',

            ]);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_FAILED
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_failed',

            ]);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Cancelled
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_CANCELLED
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_pending',

            ]);

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Refunded
        |--------------------------------------------------------------------------
        */

        if (
            $payment->status
            === SmartBuyPayment::STATUS_REFUNDED
        ) {

            $smartBuy->update([

                'status' =>
                    'payment_refunded',

            ]);

        }
    }


    /**
     * Generate Unique Payment Number.
     */
    private function generatePaymentNumber(): string
    {
        $lastPayment =
            SmartBuyPayment::query()
                ->lockForUpdate()
                ->latest('id')
                ->first();


        $nextId =
            $lastPayment
                ? $lastPayment->id + 1
                : 1;


        return 'SBP-' .
            str_pad(
                $nextId,
                6,
                '0',
                STR_PAD_LEFT
            );
    }
}
