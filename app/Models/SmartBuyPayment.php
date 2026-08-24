<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartBuyPayment extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Payment Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_REFUNDED = 'refunded';


    /*
    |--------------------------------------------------------------------------
    | All Available Statuses
    |--------------------------------------------------------------------------
    */

    public const STATUSES = [

        self::STATUS_PENDING,

        self::STATUS_PROCESSING,

        self::STATUS_COMPLETED,

        self::STATUS_FAILED,

        self::STATUS_CANCELLED,

        self::STATUS_REFUNDED,

    ];


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'smart_buy_request_id',

        'smart_buy_quote_id',

        'payment_number',

        'amount',

        'currency',

        'payment_method',

        'payment_gateway',

        'transaction_id',

        'status',

        'paid_at',

        'notes',

    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'amount' => 'decimal:2',

        'paid_at' => 'datetime',

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
    | Smart Buy Quote
    |--------------------------------------------------------------------------
    */

    public function quote(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyQuote::class,
            'smart_buy_quote_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is Completed
    |--------------------------------------------------------------------------
    */

    public function isCompleted(): bool
    {
        return
            $this->status ===
            self::STATUS_COMPLETED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is Pending
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return
            $this->status ===
            self::STATUS_PENDING;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is Processing
    |--------------------------------------------------------------------------
    */

    public function isProcessing(): bool
    {
        return
            $this->status ===
            self::STATUS_PROCESSING;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Failed
    |--------------------------------------------------------------------------
    */

    public function isFailed(): bool
    {
        return
            $this->status ===
            self::STATUS_FAILED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is Cancelled
    |--------------------------------------------------------------------------
    */

    public function isCancelled(): bool
    {
        return
            $this->status ===
            self::STATUS_CANCELLED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is Refunded
    |--------------------------------------------------------------------------
    */

    public function isRefunded(): bool
    {
        return
            $this->status ===
            self::STATUS_REFUNDED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Was Successful
    |--------------------------------------------------------------------------
    */

    public function isSuccessful(): bool
    {
        return
            $this->status ===
            self::STATUS_COMPLETED;
    }


    /*
    |--------------------------------------------------------------------------
    | Check If Payment Is In Final State
    |--------------------------------------------------------------------------
    */

    public function isTerminal(): bool
    {
        return in_array(
            $this->status,
            [

                self::STATUS_COMPLETED,

                self::STATUS_FAILED,

                self::STATUS_CANCELLED,

                self::STATUS_REFUNDED,

            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Payment Status
    |--------------------------------------------------------------------------
    */

    public function updateStatus(
        string $status
    ): bool
    {
        if (
            !in_array(
                $status,
                self::STATUSES,
                true
            )
        ) {

            throw new \InvalidArgumentException(
                "Invalid payment status: {$status}"
            );

        }


        $data = [

            'status' => $status,

        ];


        /*
        |--------------------------------------------------------------------------
        | Mark Payment As Completed
        |--------------------------------------------------------------------------
        */

        if (
            $status ===
            self::STATUS_COMPLETED
        ) {

            if (
                !$this->paid_at
            ) {

                $data['paid_at'] =
                    now();

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Clear Paid Date If Payment Is Not Completed
        |--------------------------------------------------------------------------
        */

        else {

            $data['paid_at'] =
                null;

        }


        return $this->update(
            $data
        );
    }
}
