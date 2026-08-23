<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartBuyShipment extends Model
{
    /**
     * Shipment Statuses
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_PREPARING = 'preparing';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_CANCELLED = 'cancelled';


    /**
     * All Available Statuses
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


    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'smart_buy_request_id',

        'tracking_number',

        'tracking_url',

        'carrier',

        'shipping_method',

        'status',

        'shipped_at',

        'estimated_delivery_at',

        'delivered_at',

        'country',

        'city',

        'zip_code',

        'delivery_address',

        'notes',

    ];


    /**
     * Attribute Casting
     */
    protected $casts = [

        'shipped_at' => 'datetime',

        'estimated_delivery_at' => 'datetime',

        'delivered_at' => 'datetime',

    ];


    /**
     * Smart Buy Request
     */
    public function smartBuyRequest(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyRequest::class,
            'smart_buy_request_id'
        );
    }


    /**
     * Check If Shipment Is Delivered
     */
    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }


    /**
     * Check If Shipment Is In Transit
     */
    public function isInTransit(): bool
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }


    /**
     * Update Shipment Status
     */
    public function updateStatus(string $status): bool
    {
        if (!in_array($status, self::STATUSES, true)) {
            throw new \InvalidArgumentException(
                "Invalid shipment status: {$status}"
            );
        }

        $data = [
            'status' => $status,
        ];


        if (
            in_array(
                $status,
                [
                    self::STATUS_SHIPPED,
                    self::STATUS_IN_TRANSIT,
                ],
                true
            )
            && !$this->shipped_at
        ) {
            $data['shipped_at'] = now();
        }


        if (
            $status === self::STATUS_DELIVERED
            && !$this->delivered_at
        ) {
            $data['delivered_at'] = now();
        }


        return $this->update($data);
    }
}
