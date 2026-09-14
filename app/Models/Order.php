<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Order extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Order Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_SHIPPED = 'shipped';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_FAILED = 'failed';


    /*
    |--------------------------------------------------------------------------
    | Shipment Statuses
    |--------------------------------------------------------------------------
    |
    | These statuses represent the physical shipment progress.
    |
    */

    public const SHIPMENT_STATUS_PENDING = 'pending';

    public const SHIPMENT_STATUS_PREPARING = 'preparing';

    public const SHIPMENT_STATUS_SHIPPED = 'shipped';

    public const SHIPMENT_STATUS_IN_TRANSIT = 'in_transit';

    public const SHIPMENT_STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';

    public const SHIPMENT_STATUS_DELIVERED = 'delivered';

    public const SHIPMENT_STATUS_CANCELLED = 'cancelled';

    public const SHIPMENT_STATUSES = [
        self::SHIPMENT_STATUS_PENDING,
        self::SHIPMENT_STATUS_PREPARING,
        self::SHIPMENT_STATUS_SHIPPED,
        self::SHIPMENT_STATUS_IN_TRANSIT,
        self::SHIPMENT_STATUS_OUT_FOR_DELIVERY,
        self::SHIPMENT_STATUS_DELIVERED,
        self::SHIPMENT_STATUS_CANCELLED,
    ];


    /*
    |--------------------------------------------------------------------------
    | Payment Statuses
    |--------------------------------------------------------------------------
    */

    public const PAYMENT_STATUS_PENDING = 'pending';

    public const PAYMENT_STATUS_PAID = 'paid';

    public const PAYMENT_STATUS_FAILED = 'failed';

    /*
     * Kept for backwards compatibility.
     *
     * Refund state should now be controlled by refund_status.
     */
    public const PAYMENT_STATUS_REFUNDED = 'refunded';


    /*
    |--------------------------------------------------------------------------
    | Refund Statuses
    |--------------------------------------------------------------------------
    */

    public const REFUND_STATUS_NONE = 'none';

    public const REFUND_STATUS_PENDING = 'pending';

    public const REFUND_STATUS_APPROVED = 'approved';

    public const REFUND_STATUS_REJECTED = 'rejected';

    public const REFUND_STATUS_REFUNDED = 'refunded';


    /*
    |--------------------------------------------------------------------------
    | Mass Assignment
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'refund_status',
        'payment_gateway',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'currency',
        'subtotal',
        'discount',
        'shipping',
        'tax',
        'total',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'address',
        'apartment',
        'city',
        'state',
        'postal_code',
        'notes',
        'paid_at',
    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'shipping' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /*
     * An order has one shipment.
     *
     * IMPORTANT:
     * Use "shipment", not "shipments".
     */
    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(OrderMessage::class);
    }

    public function refundRequests(): HasMany
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Order Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isShipped(): bool
    {
        return $this->status === self::STATUS_SHIPPED;
    }

    public function isInTransit(): bool
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }

    public function isOutForDelivery(): bool
    {
        return $this->status === self::STATUS_OUT_FOR_DELIVERY;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }


    /*
    |--------------------------------------------------------------------------
    | Shipment Helpers
    |--------------------------------------------------------------------------
    */

    public function hasShipment(): bool
    {
        return $this->shipment()->exists();
    }

    public function hasShipmentStatus(string $status): bool
    {
        return $this->shipment?->status === $status;
    }

    public function hasShipmentDeliveryStatus(string $status): bool
    {
        return $this->shipment?->delivery_status === $status;
    }


    /*
    |--------------------------------------------------------------------------
    | Shipment Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isShipmentPending(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_PENDING,
        );
    }

    public function isShipmentPreparing(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_PREPARING,
        );
    }

    public function isShipmentShipped(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_SHIPPED,
        );
    }

    public function isShipmentInTransit(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_IN_TRANSIT,
        );
    }

    public function isShipmentOutForDelivery(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_OUT_FOR_DELIVERY,
        );
    }

    public function isShipmentDelivered(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_DELIVERED,
        );
    }

    public function isShipmentCancelled(): bool
    {
        return $this->hasShipmentStatus(
            self::SHIPMENT_STATUS_CANCELLED,
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Shipment Delivery Status Helpers
    |--------------------------------------------------------------------------
    */

    public function isDeliveryPending(): bool
    {
        return $this->hasShipmentDeliveryStatus(
            Shipment::DELIVERY_STATUS_PENDING,
        );
    }

    public function isDeliveryInTransit(): bool
    {
        return $this->hasShipmentDeliveryStatus(
            Shipment::DELIVERY_STATUS_IN_TRANSIT,
        );
    }

    public function isDeliveryOutForDelivery(): bool
    {
        return $this->hasShipmentDeliveryStatus(
            Shipment::DELIVERY_STATUS_OUT_FOR_DELIVERY,
        );
    }

    public function isDeliveryDelivered(): bool
    {
        return $this->hasShipmentDeliveryStatus(
            Shipment::DELIVERY_STATUS_DELIVERED,
        );
    }

    public function isDeliveryFailed(): bool
    {
        return $this->hasShipmentDeliveryStatus(
            Shipment::DELIVERY_STATUS_FAILED,
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Refund Status Helpers
    |--------------------------------------------------------------------------
    |
    | refund_status is the single source of truth for the
    | customer-facing and admin-facing refund state.
    |
    */

    public function hasRefundPending(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PENDING;
    }

    public function isRefundPending(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_PENDING;
    }

    public function isRefundApproved(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_APPROVED;
    }

    public function isRefundRejected(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_REJECTED;
    }

    public function isRefunded(): bool
    {
        return $this->refund_status === self::REFUND_STATUS_REFUNDED;
    }
}
