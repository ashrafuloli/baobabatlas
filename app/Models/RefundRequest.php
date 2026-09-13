<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class RefundRequest extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'order_id',
        'requested_by',
        'amount',
        'deduction_amount',
        'deduction_reason',
        'reason',
        'message',
        'status',
        'approved_by',
        'approved_at',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'order_id' => 'integer',
            'requested_by' => 'integer',
            'amount' => 'decimal:2',
            'deduction_amount' => 'decimal:2',
            'approved_by' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requested_by',
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by',
        );
    }

    public function refund(): HasOne
    {
        return $this->hasOne(
            Refund::class,
            'refund_request_id',
        );
    }

    public function finalRefundAmount(): float
    {
        return max(
            0,
            round(
                (float) $this->amount
                - (float) $this->deduction_amount,
                2,
            ),
        );
    }

    public function hasDeduction(): bool
    {
        return (float) $this->deduction_amount > 0;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
