<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class SmartBuyShipment extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Shipment Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_PREPARING = 'preparing';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_CANCELLED = 'cancelled';


    /*
    |--------------------------------------------------------------------------
    | All Available Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUSES = [

        self::STATUS_PENDING,

        self::STATUS_PREPARING,

        self::STATUS_SHIPPED,

        self::STATUS_IN_TRANSIT,

        self::STATUS_OUT_FOR_DELIVERY,

        self::STATUS_DELIVERED,

        self::STATUS_CANCELLED,

    ];


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'smart_buy_request_id',

        'shipment_number',

        'tracking_number',

        'carrier',

        'shipping_method',

        'tracking_url',

        'status',

        'shipped_at',

        'estimated_delivery_at',

        'delivered_at',

        'country',

        'city',

        'zip_code',

        'delivery_address',

        'notes',

        'created_by',

    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'shipped_at' =>
            'datetime',

        'estimated_delivery_at' =>
            'datetime',

        'delivered_at' =>
            'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | Smart Buy Request
    |--------------------------------------------------------------------------
    */

    public function smartBuyRequest(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyRequest::class,
            'smart_buy_request_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Created By
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Status Check Methods
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return
            $this->status ===
            self::STATUS_PENDING;
    }


    public function isPreparing(): bool
    {
        return
            $this->status ===
            self::STATUS_PREPARING;
    }


    public function isShipped(): bool
    {
        return
            $this->status ===
            self::STATUS_SHIPPED;
    }


    public function isInTransit(): bool
    {
        return
            $this->status ===
            self::STATUS_IN_TRANSIT;
    }


    public function isOutForDelivery(): bool
    {
        return
            $this->status ===
            self::STATUS_OUT_FOR_DELIVERY;
    }


    public function isDelivered(): bool
    {
        return
            $this->status ===
            self::STATUS_DELIVERED;
    }


    public function isCancelled(): bool
    {
        return
            $this->status ===
            self::STATUS_CANCELLED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Shipment Has Started
    |--------------------------------------------------------------------------
    */

    public function hasStartedShipping(): bool
    {
        return in_array(
            $this->status,
            [

                self::STATUS_SHIPPED,

                self::STATUS_IN_TRANSIT,

                self::STATUS_OUT_FOR_DELIVERY,

                self::STATUS_DELIVERED,

            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Shipment Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        string $status
    ): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Status
        |--------------------------------------------------------------------------
        */

        if (
            !in_array(
                $status,
                self::STATUSES,
                true
            )
        ) {

            throw new \InvalidArgumentException(
                "Invalid shipment status: {$status}"
            );

        }


        return DB::transaction(
            function () use (
                $status
            ) {

                $data = [

                    'status' =>
                        $status,

                ];


                /*
                |--------------------------------------------------------------------------
                | Automatically Set Shipped Date
                |--------------------------------------------------------------------------
                */

                if (
                    in_array(
                        $status,
                        [

                            self::STATUS_SHIPPED,

                            self::STATUS_IN_TRANSIT,

                            self::STATUS_OUT_FOR_DELIVERY,

                        ],
                        true
                    )
                    &&
                    !$this->shipped_at
                ) {

                    $data['shipped_at'] =
                        now();

                }


                /*
                |--------------------------------------------------------------------------
                | Automatically Set Delivered Date
                |--------------------------------------------------------------------------
                */

                if (
                    $status ===
                    self::STATUS_DELIVERED
                    &&
                    !$this->delivered_at
                ) {

                    $data['delivered_at'] =
                        now();

                }


                /*
                |--------------------------------------------------------------------------
                | Update Shipment
                |--------------------------------------------------------------------------
                */

                $updated =
                    $this->update(
                        $data
                    );


                if (!$updated) {

                    return false;

                }


                /*
                |--------------------------------------------------------------------------
                | Get Smart Buy Request
                |--------------------------------------------------------------------------
                */

                $smartBuy =
                    $this->smartBuyRequest;


                if (!$smartBuy) {

                    return true;

                }


                /*
                |--------------------------------------------------------------------------
                | Synchronize Smart Buy Request Status
                |--------------------------------------------------------------------------
                */

                switch ($status) {

                    /*
                    |--------------------------------------------------------------------------
                    | Shipment Pending
                    |--------------------------------------------------------------------------
                    */

                    case self::STATUS_PENDING:

                    case self::STATUS_PREPARING:

                        /*
                         * Product is already purchased.
                         * Keep Smart Buy request at this stage.
                         */

                        if (
                            $smartBuy->status !==
                            'completed'
                        ) {

                            $smartBuy->update([

                                'status' =>
                                    'product_purchased',

                            ]);

                        }

                        break;


                    /*
                    |--------------------------------------------------------------------------
                    | Shipment Started
                    |--------------------------------------------------------------------------
                    */

                    case self::STATUS_SHIPPED:

                    case self::STATUS_IN_TRANSIT:

                    case self::STATUS_OUT_FOR_DELIVERY:

                        $smartBuy->update([

                            'status' =>
                                'in_transit',

                        ]);

                        break;


                    /*
                    |--------------------------------------------------------------------------
                    | Shipment Delivered
                    |--------------------------------------------------------------------------
                    */

                    case self::STATUS_DELIVERED:

                        $smartBuy->update([

                            'status' =>
                                'completed',

                        ]);

                        break;


                    /*
                    |--------------------------------------------------------------------------
                    | Shipment Cancelled
                    |--------------------------------------------------------------------------
                    */

                    case self::STATUS_CANCELLED:

                        /*
                         * Do not cancel the Smart Buy request.
                         *
                         * Return it to product purchased
                         * so admin can manage shipment again.
                         */

                        if (
                            $smartBuy->status !==
                            'completed'
                        ) {

                            $smartBuy->update([

                                'status' =>
                                    'product_purchased',

                            ]);

                        }

                        break;

                }


                return true;

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Shipment As Shipped
    |--------------------------------------------------------------------------
    */

    public function markAsShipped(): bool
    {
        return $this->updateStatus(
            self::STATUS_SHIPPED
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Shipment As In Transit
    |--------------------------------------------------------------------------
    */

    public function markAsInTransit(): bool
    {
        return $this->updateStatus(
            self::STATUS_IN_TRANSIT
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Shipment As Out For Delivery
    |--------------------------------------------------------------------------
    */

    public function markAsOutForDelivery(): bool
    {
        return $this->updateStatus(
            self::STATUS_OUT_FOR_DELIVERY
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Shipment As Delivered
    |--------------------------------------------------------------------------
    */

    public function markAsDelivered(): bool
    {
        return $this->updateStatus(
            self::STATUS_DELIVERED
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Shipment As Cancelled
    |--------------------------------------------------------------------------
    */

    public function markAsCancelled(): bool
    {
        return $this->updateStatus(
            self::STATUS_CANCELLED
        );
    }
}
