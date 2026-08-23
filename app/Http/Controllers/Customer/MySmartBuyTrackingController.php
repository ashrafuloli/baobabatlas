<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;

class MySmartBuyTrackingController extends Controller
{
    /**
     * Show Smart Buy shipment tracking.
     */
    public function show(
        SmartBuyRequest $smartBuy
    ) {
        abort_unless(
            $smartBuy->user_id === auth()->id(),
            403
        );


        $smartBuy->load([

            'shipment',

            'items',

        ]);


        if (!$smartBuy->shipment) {

            return redirect()
                ->route(
                    'my-smart-buy-details',
                    $smartBuy->id
                )
                ->with(
                    'error',
                    'Shipment information is not available yet.'
                );

        }


        return view(
            'backend.pages.my-smart-buy.tracking',
            compact('smartBuy')
        );
    }
}
