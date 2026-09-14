<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class TrackingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show Global Tracking Page
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        return view(
            'backend.pages.tracking.index',
            [
                'trackingType' => null,
                'order' => null,
                'orderShipment' => null,
                'smartBuy' => null,
                'shipment' => null,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Search Tracking
    |--------------------------------------------------------------------------
    */

    public function search(Request $request): View|RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'tracking_number' => [
                'required',
                'string',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Format Tracking Number
        |--------------------------------------------------------------------------
        */

        $trackingNumber = strtoupper(
            trim($validated['tracking_number']),
        );


        /*
        |--------------------------------------------------------------------------
        | Search E-commerce Order
        |--------------------------------------------------------------------------
        */

        $order = Order::query()
            ->where(
                'order_number',
                $trackingNumber,
            )
            ->with([
                'shipment',
            ])
            ->first();


        /*
        |--------------------------------------------------------------------------
        | E-commerce Order Found
        |--------------------------------------------------------------------------
        */

        if ($order !== null) {

            /*
            |--------------------------------------------------------------------------
            | Validate Order Status
            |--------------------------------------------------------------------------
            |
            | The E-commerce tracking progress is controlled by Order::status.
            |
            */

            $allowedOrderStatuses = [
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_IN_TRANSIT,
                Order::STATUS_OUT_FOR_DELIVERY,
                Order::STATUS_DELIVERED,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
                Order::STATUS_FAILED,
            ];


            /*
            |--------------------------------------------------------------------------
            | Invalid Order Status
            |--------------------------------------------------------------------------
            */

            if (
                ! in_array(
                    $order->status,
                    $allowedOrderStatuses,
                    true,
                )
            ) {
                return redirect()
                    ->route('global-tracking')
                    ->withInput()
                    ->with(
                        'error',
                        'Order tracking is currently unavailable.',
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Get E-commerce Shipment
            |--------------------------------------------------------------------------
            */

            $orderShipment = $order->shipment;


            /*
            |--------------------------------------------------------------------------
            | Show E-commerce Order Result
            |--------------------------------------------------------------------------
            */

            return view(
                'backend.pages.tracking.index',
                [
                    'trackingType' => 'order',
                    'order' => $order,
                    'orderShipment' => $orderShipment,
                    'smartBuy' => null,
                    'shipment' => null,
                ],
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Search Smart Buy Request
        |--------------------------------------------------------------------------
        */

        $smartBuy = SmartBuyRequest::query()
            ->where(
                'request_number',
                $trackingNumber,
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

        if ($smartBuy === null) {

            return redirect()
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'No order or Smart Buy request was found with this tracking number.',
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Shipment Not Available
        |--------------------------------------------------------------------------
        */

        if ($smartBuy->shipment === null) {

            return redirect()
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'This Smart Buy request was found, but shipment tracking is not available yet.',
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Smart Buy Shipment
        |--------------------------------------------------------------------------
        */

        $shipment = $smartBuy->shipment;


        /*
        |--------------------------------------------------------------------------
        | Validate Smart Buy Shipment Status
        |--------------------------------------------------------------------------
        */

        if (
            ! in_array(
                $shipment->status,
                SmartBuyShipment::STATUSES,
                true,
            )
        ) {
            return redirect()
                ->route('global-tracking')
                ->withInput()
                ->with(
                    'error',
                    'Shipment tracking is currently unavailable.',
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Show Smart Buy Result
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.tracking.index',
            [
                'trackingType' => 'smart-buy',
                'order' => null,
                'orderShipment' => null,
                'smartBuy' => $smartBuy,
                'shipment' => $shipment,
            ],
        );
    }
}
