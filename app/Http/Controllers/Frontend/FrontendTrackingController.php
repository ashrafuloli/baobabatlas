<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class FrontendTrackingController extends Controller
{
    public function index(): View
    {
        return view(
            'frontend.pages.tracking.index',
            [
                'trackingType' => null,
                'order' => null,
                'orderShipment' => null,
                'smartBuy' => null,
                'shipment' => null,
            ],
        );
    }

    public function search(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'tracking_number' => [
                'nullable',
                'string',
                'max:255',
                'required_without:request_number',
            ],
            'request_number' => [
                'nullable',
                'string',
                'max:255',
                'required_without:tracking_number',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Resolve Tracking Number
        |--------------------------------------------------------------------------
        |
        | tracking_number is the preferred field.
        |
        | request_number is kept as a backward-compatible fallback for the
        | existing Smart Buy tracking form.
        |
        */

        $trackingNumber = $validated['tracking_number']
            ?? $validated['request_number']
            ?? '';

        $trackingNumber = strtoupper(
            preg_replace(
                '/\s+/',
                '',
                trim($trackingNumber),
            ) ?? '',
        );

        /*
        |--------------------------------------------------------------------------
        | Search E-commerce Order
        |--------------------------------------------------------------------------
        |
        | E-commerce tracking is based on Order::status.
        |
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

        if ($order !== null) {

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

            if (
                ! in_array(
                    $order->status,
                    $allowedOrderStatuses,
                    true,
                )
            ) {
                return redirect()
                    ->route('tracking')
                    ->withInput()
                    ->with(
                        'error',
                        'Order tracking is currently unavailable.',
                    );
            }

            return view(
                'frontend.pages.tracking.index',
                [
                    'trackingType' => 'order',
                    'order' => $order,
                    'orderShipment' => $order->shipment,
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

        if ($smartBuy === null) {
            return redirect()
                ->route('tracking')
                ->withInput()
                ->with(
                    'error',
                    'No order or Smart Buy request was found with this tracking number.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Smart Buy Shipment
        |--------------------------------------------------------------------------
        */

        $shipment = $smartBuy->shipment;

        if ($shipment === null) {
            return redirect()
                ->route('tracking')
                ->withInput()
                ->with(
                    'error',
                    'Shipment information is not available yet.',
                );
        }

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
                ->route('tracking')
                ->withInput()
                ->with(
                    'error',
                    'Shipment tracking is currently unavailable.',
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Smart Buy Tracking Result
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.pages.tracking.index',
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
