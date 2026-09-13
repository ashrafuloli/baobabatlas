<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Shipment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_CANCELLED = 'cancelled';

    public const DELIVERY_STATUS_PENDING = 'pending';

    public const DELIVERY_STATUS_IN_TRANSIT = 'in_transit';

    public const DELIVERY_STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const DELIVERY_STATUS_DELIVERED = 'delivered';

    public const DELIVERY_STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'carrier',
        'tracking_number',
        'status',
        'delivery_status',
        'shipped_at',
        'delivered_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'order_id' => 'integer',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isDeliveryPending(): bool
    {
        return $this->delivery_status === self::DELIVERY_STATUS_PENDING;
    }

    public function isInTransit(): bool
    {
        return $this->delivery_status === self::DELIVERY_STATUS_IN_TRANSIT;
    }

    public function isOutForDelivery(): bool
    {
        return $this->delivery_status === self::DELIVERY_STATUS_OUT_FOR_DELIVERY;
    }

    public function isDelivered(): bool
    {
        return $this->delivery_status === self::DELIVERY_STATUS_DELIVERED;
    }

    public function isDeliveryFailed(): bool
    {
        return $this->delivery_status === self::DELIVERY_STATUS_FAILED;
    }

    public function hasTrackingNumber(): bool
    {
        return filled($this->tracking_number);
    }
}
