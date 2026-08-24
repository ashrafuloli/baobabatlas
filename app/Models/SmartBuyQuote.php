<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SmartBuyQuote extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Quote Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT = 'draft';

    public const STATUS_SENT = 'sent';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_EXTENSION_REQUESTED = 'extension_requested';


    /*
    |--------------------------------------------------------------------------
    | All Available Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUSES = [

        self::STATUS_DRAFT,

        self::STATUS_SENT,

        self::STATUS_ACCEPTED,

        self::STATUS_REJECTED,

        self::STATUS_EXPIRED,

        self::STATUS_EXTENSION_REQUESTED,

    ];


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'smart_buy_request_id',

        'quote_number',

        'product_total',

        'service_fee',

        'shipping_fee',

        'total_amount',

        'currency',

        'status',

        'notes',

        'sent_at',

        'accepted_at',

        'rejected_at',

        'expires_at',

        'created_by',

    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'product_total' => 'decimal:2',

        'service_fee' => 'decimal:2',

        'shipping_fee' => 'decimal:2',

        'total_amount' => 'decimal:2',

        'sent_at' => 'datetime',

        'accepted_at' => 'datetime',

        'rejected_at' => 'datetime',

        'expires_at' => 'datetime',

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
    | Quote Items
    |--------------------------------------------------------------------------
    */

    public function items(): HasMany
    {
        return $this->hasMany(
            SmartBuyQuoteItem::class,
            'smart_buy_quote_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Alias For Quote Items
    |--------------------------------------------------------------------------
    */

    public function quoteItems(): HasMany
    {
        return $this->items();
    }


    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */

    public function payment(): HasOne
    {
        return $this->hasOne(
            SmartBuyPayment::class,
            'smart_buy_quote_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Creator
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
    | Update Quote Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        string $status
    ): bool {

        if (
            !in_array(
                $status,
                self::STATUSES,
                true
            )
        ) {

            throw new \InvalidArgumentException(
                "Invalid quote status: {$status}"
            );

        }


        $data = [

            'status' => $status,

        ];


        /*
        |--------------------------------------------------------------------------
        | Sent Timestamp
        |--------------------------------------------------------------------------
        |
        | Every time a quote is sent or resent,
        | update the sent timestamp.
        |
        */

        if (
            $status === self::STATUS_SENT
        ) {

            $data['sent_at'] = now();

        }


        /*
        |--------------------------------------------------------------------------
        | Accepted Timestamp
        |--------------------------------------------------------------------------
        */

        if (
            $status === self::STATUS_ACCEPTED
            &&
            !$this->accepted_at
        ) {

            $data['accepted_at'] = now();

        }


        /*
        |--------------------------------------------------------------------------
        | Rejected Timestamp
        |--------------------------------------------------------------------------
        */

        if (
            $status === self::STATUS_REJECTED
            &&
            !$this->rejected_at
        ) {

            $data['rejected_at'] = now();

        }


        return $this->update(
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Product Total
    |--------------------------------------------------------------------------
    */

    public function calculateProductTotal(): float
    {
        return (float)

        $this
            ->items()
            ->sum(
                'total_price'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Total Amount
    |--------------------------------------------------------------------------
    */

    public function calculateTotalAmount(): float
    {
        return

            (float)
            $this->product_total

            +

            (float)
            $this->service_fee

            +

            (float)
            $this->shipping_fee;
    }


    /*
    |--------------------------------------------------------------------------
    | Refresh Quote Totals
    |--------------------------------------------------------------------------
    */

    public function refreshTotals(): bool
    {
        $productTotal =
            $this->calculateProductTotal();


        $totalAmount =

            $productTotal

            +

            (float)
            $this->service_fee

            +

            (float)
            $this->shipping_fee;


        return $this->update([

            'product_total' =>
                $productTotal,

            'total_amount' =>
                $totalAmount,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Is Draft
    |--------------------------------------------------------------------------
    */

    public function isDraft(): bool
    {
        return

            $this->status
            ===
            self::STATUS_DRAFT;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Is Sent
    |--------------------------------------------------------------------------
    */

    public function isSent(): bool
    {
        return

            $this->status
            ===
            self::STATUS_SENT;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Is Accepted
    |--------------------------------------------------------------------------
    */

    public function isAccepted(): bool
    {
        return

            $this->status
            ===
            self::STATUS_ACCEPTED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Is Rejected
    |--------------------------------------------------------------------------
    */

    public function isRejected(): bool
    {
        return

            $this->status
            ===
            self::STATUS_REJECTED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Is Expired
    |--------------------------------------------------------------------------
    */

    public function isExpired(): bool
    {
        if (
            $this->status
            ===
            self::STATUS_EXPIRED
        ) {

            return true;

        }


        if (
            $this->expires_at
            &&
            $this->expires_at->isPast()
        ) {

            return true;

        }


        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Can Be Edited
    |--------------------------------------------------------------------------
    |
    | Rejected quotes can be edited and resent.
    |
    */

    public function canBeEdited(): bool
    {
        return !in_array(
            $this->status,
            [

                self::STATUS_DRAFT,

                self::STATUS_SENT,

                self::STATUS_REJECTED,

                self::STATUS_EXPIRED,

                self::STATUS_EXTENSION_REQUESTED,

            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Can Be Accepted
    |--------------------------------------------------------------------------
    */

    public function canBeAccepted(): bool
    {
        return

            $this->status
            ===
            self::STATUS_SENT

            &&

            !$this->isExpired();
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Quote Can Be Rejected
    |--------------------------------------------------------------------------
    */

    public function canBeRejected(): bool
    {
        return

            $this->status
            ===
            self::STATUS_SENT

            &&

            !$this->isExpired();
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Quote As Sent
    |--------------------------------------------------------------------------
    |
    | This also works when a rejected quote
    | is updated and sent again.
    |
    */

    public function markAsSent(): bool
    {
        return $this->update([

            'status' =>
                self::STATUS_SENT,

            'sent_at' =>
                now(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Quote As Accepted
    |--------------------------------------------------------------------------
    */

    public function markAsAccepted(): bool
    {
        return $this->update([

            'status' =>
                self::STATUS_ACCEPTED,

            'accepted_at' =>
                now(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Mark Quote As Rejected
    |--------------------------------------------------------------------------
    */

    public function markAsRejected(): bool
    {
        return $this->update([

            'status' =>
                self::STATUS_REJECTED,

            'rejected_at' =>
                now(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Check If Quote Extension Is Requested
    |--------------------------------------------------------------------------
    */

    public function isExtensionRequested(): bool
    {
        return
            $this->status
            ===
            self::STATUS_EXTENSION_REQUESTED;
    }
}
