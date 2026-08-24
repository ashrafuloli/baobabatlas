<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;

class FrontendTrackingController extends Controller
{
    public function index()
    {
        return view('frontend.pages.tracking.index', [
            'smartBuy' => null,
            'shipment' => null,
        ]);
    }


    public function search(Request $request)
    {
        $validated = $request->validate([
            'request_number' => ['required', 'string'],
        ]);


        $requestNumber = strtoupper(
            str_replace(
                ' ',
                '',
                $validated['request_number']
            )
        );


        $smartBuy = SmartBuyRequest::query()
            ->where(
                'request_number',
                $requestNumber
            )
            ->first();


        if (!$smartBuy) {

            return redirect()
                ->route('tracking')
                ->withInput()
                ->with(
                    'error',
                    'No shipment found with this tracking number.'
                );
        }


        $shipment = $smartBuy->shipment;


        if (!$shipment) {

            return redirect()
                ->route('tracking')
                ->withInput()
                ->with(
                    'error',
                    'Shipment information is not available yet.'
                );
        }


        return view(
            'frontend.pages.tracking.index',
            compact(
                'smartBuy',
                'shipment'
            )
        );
    }
}
