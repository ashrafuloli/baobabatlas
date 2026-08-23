<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartBuyShipmentController extends Controller
{
    /**
     * Store shipment information.
     */
    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        $validated =
            $this->validateShipment(
                $request
            );


        DB::transaction(
            function () use (
                $smartBuy,
                $validated
            ) {

                $shipment =
                    $smartBuy
                        ->shipment()
                        ->updateOrCreate(
                            [],

                            [

                                'tracking_number' =>
                                    $validated[
                                    'tracking_number'
                                    ] ?? null,

                                'tracking_url' =>
                                    $validated[
                                    'tracking_url'
                                    ] ?? null,

                                'carrier' =>
                                    $validated[
                                    'carrier'
                                    ],

                                'shipping_method' =>
                                    $validated[
                                    'shipping_method'
                                    ] ?? null,

                                'status' =>
                                    $validated[
                                    'status'
                                    ],

                                'shipped_at' =>
                                    $validated[
                                    'shipped_at'
                                    ] ?? null,

                                'estimated_delivery_at' =>
                                    $validated[
                                    'estimated_delivery_at'
                                    ] ?? null,

                                'delivered_at' =>
                                    $validated[
                                    'delivered_at'
                                    ] ?? null,

                                'country' =>
                                    $validated[
                                    'country'
                                    ] ?? $smartBuy->country,

                                'city' =>
                                    $validated[
                                    'city'
                                    ] ?? $smartBuy->city,

                                'zip_code' =>
                                    $validated[
                                    'zip_code'
                                    ] ?? $smartBuy->zip_code,

                                'delivery_address' =>
                                    $validated[
                                    'delivery_address'
                                    ] ?? $smartBuy->delivery_address,

                                'notes' =>
                                    $validated[
                                    'notes'
                                    ] ?? null,

                            ]
                        );


                $this->updateRequestStatus(
                    $smartBuy,
                    $shipment
                );

            }
        );


        return back()->with(
            'success',
            'Shipment information saved successfully.'
        );
    }


    /**
     * Update shipment.
     */
    public function update(
        Request $request,
        SmartBuyShipment $shipment
    ) {
        $validated =
            $this->validateShipment(
                $request
            );


        DB::transaction(
            function () use (
                $shipment,
                $validated
            ) {

                $shipment->update([

                    'tracking_number' =>
                        $validated[
                        'tracking_number'
                        ] ?? null,

                    'tracking_url' =>
                        $validated[
                        'tracking_url'
                        ] ?? null,

                    'carrier' =>
                        $validated[
                        'carrier'
                        ],

                    'shipping_method' =>
                        $validated[
                        'shipping_method'
                        ] ?? null,

                    'status' =>
                        $validated[
                        'status'
                        ],

                    'shipped_at' =>
                        $validated[
                        'shipped_at'
                        ] ?? null,

                    'estimated_delivery_at' =>
                        $validated[
                        'estimated_delivery_at'
                        ] ?? null,

                    'delivered_at' =>
                        $validated[
                        'delivered_at'
                        ] ?? null,

                    'country' =>
                        $validated[
                        'country'
                        ] ?? null,

                    'city' =>
                        $validated[
                        'city'
                        ] ?? null,

                    'zip_code' =>
                        $validated[
                        'zip_code'
                        ] ?? null,

                    'delivery_address' =>
                        $validated[
                        'delivery_address'
                        ] ?? null,

                    'notes' =>
                        $validated[
                        'notes'
                        ] ?? null,

                ]);


                $this->updateRequestStatus(
                    $shipment
                        ->smartBuyRequest,
                    $shipment
                );

            }
        );


        return back()->with(
            'success',
            'Shipment updated successfully.'
        );
    }


    /**
     * Validate shipment.
     */
    private function validateShipment(
        Request $request
    ): array {
        return $request->validate([

            'tracking_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tracking_url' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'carrier' => [
                'required',
                'string',
                'max:255',
            ],

            'shipping_method' => [
                'nullable',
                'string',
                'max:255',
            ],

            'status' => [
                'required',
                'in:pending,processing,shipped,in_transit,delivered',
            ],

            'shipped_at' => [
                'nullable',
                'date',
            ],

            'estimated_delivery_at' => [
                'nullable',
                'date',
            ],

            'delivered_at' => [
                'nullable',
                'date',
            ],

            'country' => [
                'nullable',
                'string',
                'max:255',
            ],

            'city' => [
                'nullable',
                'string',
                'max:255',
            ],

            'zip_code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'delivery_address' => [
                'nullable',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ]);
    }


    /**
     * Synchronize request status with shipment.
     */
    private function updateRequestStatus(
        SmartBuyRequest $smartBuy,
        SmartBuyShipment $shipment
    ): void {

        switch (
        $shipment->status
        ) {

            case 'delivered':

                $smartBuy->update([

                    'status' =>
                        'completed',

                ]);

                break;


            case 'in_transit':

                $smartBuy->update([

                    'status' =>
                        'in_transit',

                ]);

                break;


            case 'processing':

            case 'shipped':

                $smartBuy->update([

                    'status' =>
                        'product_purchased',

                ]);

                break;

        }
    }
}
