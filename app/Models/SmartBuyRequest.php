<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SmartBuyRequest extends Model
{
    /**
     * Request Statuses
     */
    public const STATUS_PENDING = 'pending';

    public const STATUS_QUOTE_SENT = 'quote_sent';

    public const STATUS_QUOTE_ACCEPTED = 'quote_accepted';

    public const STATUS_QUOTE_REJECTED = 'quote_rejected';

    public const STATUS_PAYMENT_COMPLETED = 'payment_completed';

    public const STATUS_PRODUCT_PURCHASED = 'product_purchased';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';


    /**
     * All Available Statuses
     */
    public const STATUSES = [

        self::STATUS_PENDING,

        self::STATUS_QUOTE_SENT,

        self::STATUS_QUOTE_ACCEPTED,

        self::STATUS_QUOTE_REJECTED,

        self::STATUS_PAYMENT_COMPLETED,

        self::STATUS_PRODUCT_PURCHASED,

        self::STATUS_IN_TRANSIT,

        self::STATUS_COMPLETED,

        self::STATUS_CANCELLED,

    ];


    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

        'user_id',

        'request_number',

        'first_name',

        'last_name',

        'phone',

        'email',

        'country',

        'city',

        'zip_code',

        'delivery_address',

        'status',

    ];


    /**
     * Attribute Casting
     */
    protected $casts = [

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

    ];


    /**
     * User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /**
     * Request Items
     */
    public function items(): HasMany
    {
        return $this->hasMany(
            SmartBuyItem::class,
            'smart_buy_request_id'
        );
    }


    /**
     * All Quotes
     */
    public function quotes(): HasMany
    {
        return $this->hasMany(
            SmartBuyQuote::class,
            'smart_buy_request_id'
        );
    }


    /**
     * Latest Quote
     */
    public function latestQuote(): HasOne
    {
        return $this->hasOne(
            SmartBuyQuote::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * Quote Alias
     *
     * Keeps compatibility with:
     * $smartBuyRequest->quote
     */
    public function quote(): HasOne
    {
        return $this->hasOne(
            SmartBuyQuote::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * All Payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(
            SmartBuyPayment::class,
            'smart_buy_request_id'
        );
    }


    /**
     * Latest Payment
     */
    public function latestPayment(): HasOne
    {
        return $this->hasOne(
            SmartBuyPayment::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * Payment Alias
     */
    public function payment(): HasOne
    {
        return $this->hasOne(
            SmartBuyPayment::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * All Shipments
     */
    public function shipments(): HasMany
    {
        return $this->hasMany(
            SmartBuyShipment::class,
            'smart_buy_request_id'
        );
    }


    /**
     * Latest Shipment
     */
    public function latestShipment(): HasOne
    {
        return $this->hasOne(
            SmartBuyShipment::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * Shipment Alias
     */
    public function shipment(): HasOne
    {
        return $this->hasOne(
            SmartBuyShipment::class,
            'smart_buy_request_id'
        )->latestOfMany();
    }


    /**
     * Update Request Status
     */
    public function updateStatus(string $status): bool
    {
        if (!in_array($status, self::STATUSES, true)) {
            throw new \InvalidArgumentException(
                "Invalid Smart Buy status: {$status}"
            );
        }

        return $this->update([
            'status' => $status,
        ]);
    }


    /**
     * Check Request Status
     */
    public function hasStatus(string $status): bool
    {
        return $this->status === $status;
    }


    /**
     * Check If Quote Is Available
     */
    public function hasQuote(): bool
    {
        return $this->quotes()->exists();
    }


    /**
     * Check If Payment Is Completed
     */
    public function isPaymentCompleted(): bool
    {
        return $this->status === self::STATUS_PAYMENT_COMPLETED
            || $this->status === self::STATUS_PRODUCT_PURCHASED
            || $this->status === self::STATUS_IN_TRANSIT
            || $this->status === self::STATUS_COMPLETED;
    }


    /**
     * Check If Product Is Purchased
     */
    public function isProductPurchased(): bool
    {
        return $this->status === self::STATUS_PRODUCT_PURCHASED
            || $this->status === self::STATUS_IN_TRANSIT
            || $this->status === self::STATUS_COMPLETED;
    }


    /**
     * Check If Shipment Is Active
     */
    public function isInTransit(): bool
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }


    /**
     * Check If Request Is Completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }


    /**
     * Check If Request Is Cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
