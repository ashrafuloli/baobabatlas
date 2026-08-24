<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyQuote;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MySmartBuyQuoteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Smart Buy Quote
    |--------------------------------------------------------------------------
    */

    public function show(
        SmartBuyRequest $smartBuy
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Load Smart Buy And Quote
        |--------------------------------------------------------------------------
        */

        $smartBuy->load([

            'items',

            'quote.quoteItems.smartBuyItem',

            'latestQuote.quoteItems.smartBuyItem',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Quote
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        /*
        |--------------------------------------------------------------------------
        | Quote Not Found
        |--------------------------------------------------------------------------
        */

        if (!$quote) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'No quote is available yet.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Mark Expired Quote
        |--------------------------------------------------------------------------
        */

        if (
            $quote->isExpired()
            &&
            !$quote->isAccepted()
            &&
            !$quote->isRejected()
        ) {

            if (
                $quote->status
                !==
                SmartBuyQuote::STATUS_EXPIRED
            ) {

                $quote->update([

                    'status' =>
                        SmartBuyQuote::STATUS_EXPIRED,

                ]);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Show Quote
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.my-smart-buy.quote',
            compact(
                'smartBuy',
                'quote'
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Accept Smart Buy Quote
    |--------------------------------------------------------------------------
    */

    public function accept(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Load Quote
        |--------------------------------------------------------------------------
        */

        $smartBuy->load([

            'latestQuote',

            'quote',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Quote
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        /*
        |--------------------------------------------------------------------------
        | Quote Not Found
        |--------------------------------------------------------------------------
        */

        if (!$quote) {

            return back()->with(
                'error',
                'Quote not found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Smart Buy Status
        |--------------------------------------------------------------------------
        */

        if (
            $smartBuy->status
            !==
            'quote_sent'
        ) {

            return back()->with(
                'error',
                'This quote cannot be accepted at this stage.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Quote Status
        |--------------------------------------------------------------------------
        */

        if (
            !$quote->isSent()
        ) {

            return back()->with(
                'error',
                'This quote is not available for acceptance.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Expiration
        |--------------------------------------------------------------------------
        */

        if (
            $quote->isExpired()
        ) {

            $quote->update([

                'status' =>
                    SmartBuyQuote::STATUS_EXPIRED,

            ]);


            return back()->with(
                'error',
                'This quote has expired and can no longer be accepted.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Accept Quote
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $quote,
                $smartBuy
            ) {

                /*
                |--------------------------------------------------------------------------
                | Update Quote
                |--------------------------------------------------------------------------
                */

                $quote->update([

                    'status' =>
                        SmartBuyQuote::STATUS_ACCEPTED,

                    'accepted_at' =>
                        now(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy
                |--------------------------------------------------------------------------
                */

                $smartBuy->update([

                    'status' =>
                        'quote_accepted',

                    'quote_accepted_at' =>
                        now(),

                ]);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect To Payment
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'my-smart-buy.payment',
                $smartBuy->id
            )
            ->with(
                'success',
                'Quote accepted successfully. You can now proceed.'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | Reject Smart Buy Quote
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'reason' => [

                'nullable',

                'string',

                'max:1000',

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

        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Quote
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        /*
        |--------------------------------------------------------------------------
        | Quote Not Found
        |--------------------------------------------------------------------------
        */

        if (!$quote) {

            return back()->with(
                'error',
                'Quote not found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Smart Buy Status
        |--------------------------------------------------------------------------
        */

        if (
            $smartBuy->status
            !==
            'quote_sent'
        ) {

            return back()->with(
                'error',
                'This quote cannot be rejected at this stage.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Quote Status
        |--------------------------------------------------------------------------
        */

        if (
            !$quote->isSent()
        ) {

            return back()->with(
                'error',
                'This quote is not available for rejection.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Expiration
        |--------------------------------------------------------------------------
        */

        if (
            $quote->isExpired()
        ) {

            $quote->update([

                'status' =>
                    SmartBuyQuote::STATUS_EXPIRED,

            ]);


            return back()->with(
                'error',
                'This quote has expired.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Prepare Rejection Notes
        |--------------------------------------------------------------------------
        |
        | Remove all previous rejection reasons
        | and keep only the latest rejection reason.
        |
        */

        $notes =
            $quote->notes;


        /*
        |--------------------------------------------------------------------------
        | Remove Previous Rejection Reason
        |--------------------------------------------------------------------------
        */

        if (
            !empty($notes)
        ) {

            $notes =
                preg_replace(
                    '/\s*Rejection Reason:\s*.*/s',
                    '',
                    $notes
                );


            $notes =
                trim($notes);

        }


        /*
        |--------------------------------------------------------------------------
        | Add Latest Rejection Reason
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
            $validated['reason']
            )
        ) {

            $rejectionReason =

                'Rejection Reason: '

                .

                trim(
                    $validated['reason']
                );


            $notes =

                !empty($notes)

                    ?

                    $notes
                    .
                    PHP_EOL
                    .
                    PHP_EOL
                    .
                    $rejectionReason

                    :

                    $rejectionReason;

        }


        /*
        |--------------------------------------------------------------------------
        | Reject Quote
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $quote,
                $smartBuy,
                $notes
            ) {

                /*
                |--------------------------------------------------------------------------
                | Update Quote
                |--------------------------------------------------------------------------
                */

                $quote->update([

                    'status' =>
                        SmartBuyQuote::STATUS_REJECTED,

                    'rejected_at' =>
                        now(),

                    'notes' =>
                        $notes,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy
                |--------------------------------------------------------------------------
                */

                $smartBuy->update([

                    'status' =>
                        'quote_rejected',

                    'quote_rejected_at' =>
                        now(),

                ]);

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'my-smart-buy.details',
                $smartBuy->id
            )
            ->with(
                'success',
                'Quote has been rejected successfully.'
            );

    }


    /**
     * Request quote extension.
     */
    public function requestExtension(
        SmartBuyRequest $smartBuy
    ) {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Load Quote
        |--------------------------------------------------------------------------
        */

        $smartBuy->load([

            'latestQuote',

            'quote',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Quote
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote;


        /*
        |--------------------------------------------------------------------------
        | Quote Not Found
        |--------------------------------------------------------------------------
        */

        if (!$quote) {

            return back()->with(
                'error',
                'Quote not found.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Check Quote Expiration
        |--------------------------------------------------------------------------
        */

        if (
            !$quote->isExpired()
        ) {

            return back()->with(
                'error',
                'This quote has not expired yet.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Request
        |--------------------------------------------------------------------------
        */

        if (
            $quote->status
            ===
            SmartBuyQuote::STATUS_EXTENSION_REQUESTED
        ) {

            return back()->with(
                'error',
                'A quote extension request has already been submitted.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Update Quote Status
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $quote,
                $smartBuy
            ) {

                $quote->update([

                    'status' =>
                        SmartBuyQuote::STATUS_EXTENSION_REQUESTED,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy Status
                |--------------------------------------------------------------------------
                */

                $smartBuy->update([

                    'status' =>
                        'quote_extension_requested',

                ]);

            }
        );


        return back()->with(
            'success',
            'Your quote extension request has been sent successfully.'
        );

    }
}
