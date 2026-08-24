<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Http\Request;

class MySmartBuyTrackingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Search Tracking
    |--------------------------------------------------------------------------
    */

    public function search(
        Request $request
    ) {

        $validated =
            $request->validate([

                'request_number' => [

                    'required',

                    'string',

                    'max:255',

                ],

            ]);


        $smartBuy =
            SmartBuyRequest::query()
                ->where(
                    'user_id',
                    auth()->id()
                )
                ->where(
                    'request_number',
                    $validated['request_number']
                )
                ->first();


        if (!$smartBuy) {

            return back()
                ->with(
                    'error',
                    'No Smart Buy request was found with this request number.'
                );

        }


        if (!$smartBuy->shipment) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Shipment information is not available yet.'
                );

        }


        return redirect()
            ->route(
                'my-smart-buy.tracking',
                $smartBuy->id
            );

    }


    /*
    |--------------------------------------------------------------------------
    | Show Smart Buy Shipment Tracking
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
        | Load Required Relationships
        |--------------------------------------------------------------------------
        */

        $smartBuy->load([

            'items',

            'quote.quoteItems.smartBuyItem',

            'latestQuote.quoteItems.smartBuyItem',

            'shipment.creator',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Shipment Not Available
        |--------------------------------------------------------------------------
        */

        if (
            !$smartBuy->shipment
        ) {

            return redirect()
                ->route(
                    'my-smart-buy.details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Shipment information is not available yet.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Shipment
        |--------------------------------------------------------------------------
        */

        $shipment =
            $smartBuy->shipment;


        /*
        |--------------------------------------------------------------------------
        | Validate Shipment Status
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $shipment->status,
                SmartBuyShipment::STATUSES,
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
                    'Shipment tracking is currently unavailable.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Show Tracking Page
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.my-smart-buy.tracking',
            compact(

                'smartBuy',

                'shipment'

            )
        );

    }

}
