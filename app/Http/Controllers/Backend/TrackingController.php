<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Global Tracking Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view(
            'backend.pages.tracking.index',
            [
                'smartBuy' => null,
                'shipment' => null,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Search Smart Buy Tracking
    |--------------------------------------------------------------------------
    */

    public function search(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'request_number' => [

                'required',

                'string',

                'max:255',

            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Format Request Number
        |--------------------------------------------------------------------------
        */

        $requestNumber = strtoupper(
            trim(
                $validated['request_number']
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Find Smart Buy Request
        |--------------------------------------------------------------------------
        */

        $smartBuy = SmartBuyRequest::query()
            ->where(
                'request_number',
                $requestNumber
            )
            ->with([

                'items',

                'shipment',

            ])
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Smart Buy Not Found
        |--------------------------------------------------------------------------
        */

        if (!$smartBuy) {

            return redirect()
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'No Smart Buy request was found with this tracking number.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Shipment Not Available
        |--------------------------------------------------------------------------
        */

        if (!$smartBuy->shipment) {

            return redirect()
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'This Smart Buy request was found, but shipment tracking is not available yet.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Shipment
        |--------------------------------------------------------------------------
        */

        $shipment = $smartBuy->shipment;


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
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'Shipment tracking is currently unavailable.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Show Result
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.tracking.index',
            compact(
                'smartBuy',
                'shipment'
            )
        );
    }
}
