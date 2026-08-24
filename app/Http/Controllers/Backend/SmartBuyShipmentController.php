<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use App\Models\SmartBuyShipment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SmartBuyShipmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Create Shipment Page
    |--------------------------------------------------------------------------
    */

    public function create(
        SmartBuyRequest $smartBuy
    ) {
        $smartBuy->load([

            'shipment',

            'user',

            'items',

            'quote.quoteItems.smartBuyItem',

            'latestQuote.quoteItems.smartBuyItem',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Shipment Already Exists
        |--------------------------------------------------------------------------
        */

        if ($smartBuy->shipment) {

            return redirect()
                ->route(
                    'smart-buy.shipment.edit',
                    $smartBuy->shipment
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Shipment Can Only Be Created
        |--------------------------------------------------------------------------
        */

        if (
            !$this->canManageShipment(
                $smartBuy
            )
        ) {

            return redirect()
                ->route(
                    'smart-buy.show',
                    $smartBuy
                )
                ->with(
                    'error',
                    'Shipment can only be created after the product has been purchased.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Shipment Summary
        |--------------------------------------------------------------------------
        */

        $shipmentSummary =
            $this->shipmentSummary(
                $smartBuy
            );


        return view(
            'backend.pages.smart-buy.shipment-create',
            compact(

                'smartBuy',

                'shipmentSummary'

            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Shipment
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        /*
        |--------------------------------------------------------------------------
        | Load Required Relations
        |--------------------------------------------------------------------------
        */

        $smartBuy->load([

            'shipment',

            'quote',

            'latestQuote',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Shipment
        |--------------------------------------------------------------------------
        */

        if ($smartBuy->shipment) {

            return redirect()
                ->route(
                    'smart-buy.shipment.edit',
                    $smartBuy->shipment
                )
                ->with(
                    'error',
                    'A shipment already exists for this Smart Buy request.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Request Status
        |--------------------------------------------------------------------------
        */

        if (
            !$this->canManageShipment(
                $smartBuy
            )
        ) {

            return back()->with(
                'error',
                'Shipment cannot be created at this stage.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Shipment
        |--------------------------------------------------------------------------
        */

        $validated =
            $this->validateShipment(
                $request
            );


        /*
        |--------------------------------------------------------------------------
        | Create Shipment
        |--------------------------------------------------------------------------
        */

        $shipment =
            DB::transaction(
                function () use (
                    $smartBuy,
                    $validated
                ) {

                    $shipment =
                        $smartBuy
                            ->shipment()
                            ->create([

                                /*
                                |--------------------------------------------------------------------------
                                | Shipment Number
                                |--------------------------------------------------------------------------
                                */

                                'shipment_number' =>
                                    $this->generateShipmentNumber(),


                                /*
                                |--------------------------------------------------------------------------
                                | Tracking Information
                                |--------------------------------------------------------------------------
                                */

                                'tracking_number' =>
                                    $validated[
                                    'tracking_number'
                                    ] ?? null,

                                'carrier' =>
                                    $validated[
                                    'carrier'
                                    ] ?? null,

                                'tracking_url' =>
                                    $validated[
                                    'tracking_url'
                                    ] ?? null,

                                'shipping_method' =>
                                    $validated[
                                    'shipping_method'
                                    ] ?? null,


                                /*
                                |--------------------------------------------------------------------------
                                | Status
                                |--------------------------------------------------------------------------
                                */

                                'status' =>
                                    $validated[
                                    'status'
                                    ],


                                /*
                                |--------------------------------------------------------------------------
                                | Shipping Dates
                                |--------------------------------------------------------------------------
                                */

                                'shipped_at' =>
                                    $this->resolveShippedAt(
                                        $validated
                                    ),

                                'estimated_delivery_at' =>
                                    $validated[
                                    'estimated_delivery_at'
                                    ] ?? null,

                                'delivered_at' =>
                                    $this->resolveDeliveredAt(
                                        $validated
                                    ),


                                /*
                                |--------------------------------------------------------------------------
                                | Delivery Information
                                |--------------------------------------------------------------------------
                                */

                                'country' =>
                                    $validated[
                                    'country'
                                    ]
                                    ?? $smartBuy->country
                                        ?? null,

                                'city' =>
                                    $validated[
                                    'city'
                                    ]
                                    ?? $smartBuy->city
                                        ?? null,

                                'zip_code' =>
                                    $validated[
                                    'zip_code'
                                    ]
                                    ?? $smartBuy->zip_code
                                        ?? null,

                                'delivery_address' =>
                                    $validated[
                                    'delivery_address'
                                    ]
                                    ?? $smartBuy->delivery_address
                                        ?? null,


                                /*
                                |--------------------------------------------------------------------------
                                | Notes
                                |--------------------------------------------------------------------------
                                */

                                'notes' =>
                                    $validated[
                                    'notes'
                                    ] ?? null,


                                /*
                                |--------------------------------------------------------------------------
                                | Created By
                                |--------------------------------------------------------------------------
                                */

                                'created_by' =>
                                    auth()->id(),

                            ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Synchronize Smart Buy Status
                    |--------------------------------------------------------------------------
                    */

                    $this->updateRequestStatus(
                        $smartBuy,
                        $shipment
                    );


                    return $shipment;

                }
            );


        return redirect()
            ->route(
                'smart-buy.shipment.edit',
                $shipment
            )
            ->with(
                'success',
                'Shipment created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Shipment Page
    |--------------------------------------------------------------------------
    */

    public function edit(
        SmartBuyShipment $shipment
    ) {
        $shipment->load([

            'smartBuyRequest.user',

            'smartBuyRequest.items',

            'smartBuyRequest.quote.quoteItems.smartBuyItem',

            'creator',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Smart Buy Request
        |--------------------------------------------------------------------------
        */

        $smartBuy =
            $shipment->smartBuyRequest;


        /*
        |--------------------------------------------------------------------------
        | Shipment Summary
        |--------------------------------------------------------------------------
        */

        $shipmentSummary =
            $this->shipmentSummary(
                $smartBuy
            );


        /*
        |--------------------------------------------------------------------------
        | Return Edit View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.smart-buy.shipment-edit',
            compact(

                'shipment',

                'smartBuy',

                'shipmentSummary'

            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Shipment
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        SmartBuyShipment $shipment
    ) {
        /*
        |--------------------------------------------------------------------------
        | Load Smart Buy Request
        |--------------------------------------------------------------------------
        */

        $shipment->load(
            'smartBuyRequest'
        );


        /*
        |--------------------------------------------------------------------------
        | Validate Shipment
        |--------------------------------------------------------------------------
        */

        $validated =
            $this->validateShipment(
                $request
            );


        DB::transaction(
            function () use (
                $shipment,
                $validated
            ) {

                /*
                |--------------------------------------------------------------------------
                | Resolve Dates
                |--------------------------------------------------------------------------
                */

                $shippedAt =
                    $this->resolveShippedAt(
                        $validated,
                        $shipment
                    );


                $deliveredAt =
                    $this->resolveDeliveredAt(
                        $validated,
                        $shipment
                    );


                /*
                |--------------------------------------------------------------------------
                | Update Shipment
                |--------------------------------------------------------------------------
                */

                $shipment->update([

                    'tracking_number' =>
                        $validated[
                        'tracking_number'
                        ] ?? null,

                    'carrier' =>
                        $validated[
                        'carrier'
                        ] ?? null,

                    'tracking_url' =>
                        $validated[
                        'tracking_url'
                        ] ?? null,

                    'shipping_method' =>
                        $validated[
                        'shipping_method'
                        ] ?? null,

                    'status' =>
                        $validated[
                        'status'
                        ],

                    'shipped_at' =>
                        $shippedAt,

                    'estimated_delivery_at' =>
                        $validated[
                        'estimated_delivery_at'
                        ] ?? null,

                    'delivered_at' =>
                        $deliveredAt,

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


                /*
                |--------------------------------------------------------------------------
                | Refresh Model
                |--------------------------------------------------------------------------
                */

                $shipment->refresh();


                /*
                |--------------------------------------------------------------------------
                | Synchronize Smart Buy Status
                |--------------------------------------------------------------------------
                */

                $this->updateRequestStatus(
                    $shipment->smartBuyRequest,
                    $shipment
                );

            }
        );


        return back()->with(
            'success',
            'Shipment updated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Shipment Cost Summary
    |--------------------------------------------------------------------------
    */

    private function shipmentSummary(
        SmartBuyRequest $smartBuy
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Get Latest Available Quote
        |--------------------------------------------------------------------------
        */

        $quote =
            $smartBuy->latestQuote
            ?? $smartBuy->quote
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Quote Items
        |--------------------------------------------------------------------------
        */

        $quoteItems =
            $quote?->quoteItems
            ?? collect();


        /*
        |--------------------------------------------------------------------------
        | Calculate Product Total From Quote Items
        |--------------------------------------------------------------------------
        */

        $calculatedProductTotal = 0;


        foreach ($quoteItems as $quoteItem) {

            $quantity =
                (float) (
                    $quoteItem->quantity
                    ?? $quoteItem->smartBuyItem?->quantity
                    ?? 1
                );


            $unitPrice =
                (float) (
                    $quoteItem->unit_price
                    ?? $quoteItem->price
                    ?? 0
                );


            $itemTotal =
                $quoteItem->total_price
                ?? $quoteItem->total_amount
                ?? $quoteItem->total
                ?? null;


            /*
            |--------------------------------------------------------------------------
            | If Stored Total Exists
            |--------------------------------------------------------------------------
            */

            if (
                $itemTotal !== null
            ) {

                $itemTotal =
                    (float) $itemTotal;

            } else {

                $itemTotal =
                    $unitPrice
                    *
                    $quantity;

            }


            $calculatedProductTotal +=
                $itemTotal;

        }


        /*
        |--------------------------------------------------------------------------
        | Product Total
        |--------------------------------------------------------------------------
        |
        | Use stored quote total when it has a valid value.
        | Otherwise calculate it from quote items.
        |
        */

        $storedProductTotal =
            $quote?->product_total
            ?? $quote?->products_total
            ?? $quote?->subtotal
            ?? null;


        if (
            $storedProductTotal !== null
            &&
            (float) $storedProductTotal > 0
        ) {

            $productTotal =
                (float) $storedProductTotal;

        } else {

            $productTotal =
                $calculatedProductTotal;

        }


        /*
        |--------------------------------------------------------------------------
        | Service Fee
        |--------------------------------------------------------------------------
        */

        $serviceFee =
            (float) (
                $quote?->service_fee
                ?? $smartBuy->service_fee
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Shipping Cost
        |--------------------------------------------------------------------------
        */

        $shippingCost =
            (float) (
                $quote?->shipping_fee
                ?? $quote?->shipping_cost
                ?? $smartBuy->shipping_fee
                ?? $smartBuy->shipping_cost
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $calculatedTotal =
            $productTotal
            +
            $serviceFee
            +
            $shippingCost;


        /*
        |--------------------------------------------------------------------------
        | Stored Quote Total
        |--------------------------------------------------------------------------
        */

        $storedTotalAmount =
            $quote?->total_amount
            ?? $quote?->total
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Total Amount
        |--------------------------------------------------------------------------
        |
        | Use quote total if valid.
        | Otherwise use calculated total.
        |
        */

        if (
            $storedTotalAmount !== null
            &&
            (float) $storedTotalAmount > 0
        ) {

            $totalAmount =
                (float) $storedTotalAmount;

        } else {

            $totalAmount =
                $calculatedTotal;

        }


        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency =
            $quote?->currency
            ?? $smartBuy->currency
            ?? 'USD';


        /*
        |--------------------------------------------------------------------------
        | Product Count
        |--------------------------------------------------------------------------
        */

        $productCount =
            $quoteItems->count() > 0
                ? $quoteItems->count()
                : $smartBuy->items->count();


        return [

            /*
            |--------------------------------------------------------------------------
            | Quote
            |--------------------------------------------------------------------------
            */

            'quote' =>
                $quote,


            /*
            |--------------------------------------------------------------------------
            | Quote Items
            |--------------------------------------------------------------------------
            */

            'quote_items' =>
                $quoteItems,


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            'currency' =>
                $currency,


            /*
            |--------------------------------------------------------------------------
            | Product Count
            |--------------------------------------------------------------------------
            */

            'product_count' =>
                $productCount,


            /*
            |--------------------------------------------------------------------------
            | Product Total
            |--------------------------------------------------------------------------
            */

            'product_total' =>
                $productTotal,


            /*
            |--------------------------------------------------------------------------
            | Calculated Product Total
            |--------------------------------------------------------------------------
            */

            'calculated_product_total' =>
                $calculatedProductTotal,


            /*
            |--------------------------------------------------------------------------
            | Service Fee
            |--------------------------------------------------------------------------
            */

            'service_fee' =>
                $serviceFee,


            /*
            |--------------------------------------------------------------------------
            | Shipping Cost
            |--------------------------------------------------------------------------
            */

            'shipping_cost' =>
                $shippingCost,


            /*
            |--------------------------------------------------------------------------
            | Total Amount
            |--------------------------------------------------------------------------
            */

            'total_amount' =>
                $totalAmount,

        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Validate Shipment
    |--------------------------------------------------------------------------
    */

    private function validateShipment(
        Request $request
    ): array {

        return $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Tracking Information
            |--------------------------------------------------------------------------
            */

            'tracking_number' => [

                'nullable',

                'string',

                'max:255',

            ],

            'carrier' => [

                'nullable',

                'string',

                'max:255',

            ],

            'tracking_url' => [

                'nullable',

                'url',

                'max:2048',

            ],

            'shipping_method' => [

                'nullable',

                'string',

                'max:255',

            ],


            /*
            |--------------------------------------------------------------------------
            | Shipment Status
            |--------------------------------------------------------------------------
            */

            'status' => [

                'required',

                'in:' .
                implode(
                    ',',
                    SmartBuyShipment::STATUSES
                ),

            ],


            /*
            |--------------------------------------------------------------------------
            | Shipping Dates
            |--------------------------------------------------------------------------
            */

            'shipped_at' => [

                'nullable',

                'date',

            ],

            'estimated_delivery_at' => [

                'nullable',

                'date',

                'after_or_equal:shipped_at',

            ],

            'delivered_at' => [

                'nullable',

                'date',

            ],


            /*
            |--------------------------------------------------------------------------
            | Delivery Information
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            'notes' => [

                'nullable',

                'string',

            ],

        ]);

    }


    /*
    |--------------------------------------------------------------------------
    | Check If Shipment Can Be Managed
    |--------------------------------------------------------------------------
    */

    private function canManageShipment(
        SmartBuyRequest $smartBuy
    ): bool {

        return in_array(
            $smartBuy->status,
            [

                'payment_completed',

                'product_purchased',

                'in_transit',

            ],
            true
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Shipped Date
    |--------------------------------------------------------------------------
    */

    private function resolveShippedAt(
        array $validated,
        ?SmartBuyShipment $shipment = null
    ): mixed {

        /*
        |--------------------------------------------------------------------------
        | Use Submitted Date
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
            $validated['shipped_at']
            )
        ) {

            return
                $validated['shipped_at'];

        }


        /*
        |--------------------------------------------------------------------------
        | Keep Existing Date
        |--------------------------------------------------------------------------
        */

        if (
            $shipment
            &&
            $shipment->shipped_at
        ) {

            return
                $shipment->shipped_at;

        }


        /*
        |--------------------------------------------------------------------------
        | Automatically Set Shipped Date
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $validated['status'],
                [

                    SmartBuyShipment::STATUS_SHIPPED,

                    SmartBuyShipment::STATUS_IN_TRANSIT,

                    SmartBuyShipment::STATUS_OUT_FOR_DELIVERY,

                    SmartBuyShipment::STATUS_DELIVERED,

                ],
                true
            )
        ) {

            return now();

        }


        return null;

    }


    /*
    |--------------------------------------------------------------------------
    | Resolve Delivered Date
    |--------------------------------------------------------------------------
    */

    private function resolveDeliveredAt(
        array $validated,
        ?SmartBuyShipment $shipment = null
    ): mixed {

        /*
        |--------------------------------------------------------------------------
        | Use Submitted Date
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
            $validated['delivered_at']
            )
        ) {

            return
                $validated['delivered_at'];

        }


        /*
        |--------------------------------------------------------------------------
        | Keep Existing Date
        |--------------------------------------------------------------------------
        */

        if (
            $shipment
            &&
            $shipment->delivered_at
        ) {

            return
                $shipment->delivered_at;

        }


        /*
        |--------------------------------------------------------------------------
        | Automatically Set Delivered Date
        |--------------------------------------------------------------------------
        */

        if (
            $validated['status']
            ===
            SmartBuyShipment::STATUS_DELIVERED
        ) {

            return now();

        }


        return null;

    }


    /*
    |--------------------------------------------------------------------------
    | Synchronize Smart Buy Request Status
    |--------------------------------------------------------------------------
    */

    private function updateRequestStatus(
        SmartBuyRequest $smartBuy,
        SmartBuyShipment $shipment
    ): void {

        switch (
        $shipment->status
        ) {

            /*
            |--------------------------------------------------------------------------
            | Pending / Preparing
            |--------------------------------------------------------------------------
            */

            case SmartBuyShipment::STATUS_PENDING:

            case SmartBuyShipment::STATUS_PREPARING:

                $smartBuy->update([

                    'status' =>
                        'product_purchased',

                ]);

                break;


            /*
            |--------------------------------------------------------------------------
            | Shipment In Progress
            |--------------------------------------------------------------------------
            */

            case SmartBuyShipment::STATUS_SHIPPED:

            case SmartBuyShipment::STATUS_IN_TRANSIT:

            case SmartBuyShipment::STATUS_OUT_FOR_DELIVERY:

                $smartBuy->update([

                    'status' =>
                        'in_transit',

                ]);

                break;


            /*
            |--------------------------------------------------------------------------
            | Delivered
            |--------------------------------------------------------------------------
            */

            case SmartBuyShipment::STATUS_DELIVERED:

                $smartBuy->update([

                    'status' =>
                        'completed',

                ]);

                break;


            /*
            |--------------------------------------------------------------------------
            | Cancelled
            |--------------------------------------------------------------------------
            */

            case SmartBuyShipment::STATUS_CANCELLED:

                $smartBuy->update([

                    'status' =>
                        'product_purchased',

                ]);

                break;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Generate Unique Shipment Number
    |--------------------------------------------------------------------------
    */

    private function generateShipmentNumber(): string
    {

        $lastShipment =
            SmartBuyShipment::query()
                ->lockForUpdate()
                ->latest('id')
                ->first();


        $nextId =
            $lastShipment
                ? $lastShipment->id + 1
                : 1;


        return
            'SBS-' .
            str_pad(
                $nextId,
                6,
                '0',
                STR_PAD_LEFT
            );

    }

}
