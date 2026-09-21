<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
use App\Models\RefundRequest;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

final class RejectRefundRequest
{
    /**
     * Reject a pending refund request.
     */
    public function execute(
        RefundRequest $refundRequest,
        User $admin,
        ?string $adminNote = null,
    ): RefundRequest {
        return DB::transaction(function () use (
            $refundRequest,
            $admin,
            $adminNote,
        ): RefundRequest {
            /*
            |--------------------------------------------------------------------------
            | Lock Refund Request
            |--------------------------------------------------------------------------
            */

            $refundRequest = RefundRequest::query()
                ->whereKey($refundRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Validate Status
            |--------------------------------------------------------------------------
            */

            if (!$refundRequest->isPending()) {
                throw new DomainException(
                    'This refund request can no longer be rejected.',
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Lock Order
            |--------------------------------------------------------------------------
            |
            | We lock the order because its refund status will be updated.
            |
            */

            $order = Order::query()
                ->whereKey($refundRequest->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Reject Refund Request
            |--------------------------------------------------------------------------
            */

            $refundRequest->update([
                'status' => RefundRequest::STATUS_REJECTED,

                'approved_by' => $admin->id,

                'approved_at' => now(),

                'admin_note' => $adminNote !== null
                    ? trim($adminNote)
                    : null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Order Refund Status
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | No stock change happens here.
            |
            | The order was never refunded, so the existing stock remains
            | unchanged.
            |
            */

            if (
                defined(
                    Order::class . '::REFUND_STATUS_REJECTED',
                )
            ) {
                $order->update([
                    'refund_status' =>
                        Order::REFUND_STATUS_REJECTED,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Return Fresh Refund Request
            |--------------------------------------------------------------------------
            */

            return $refundRequest->fresh([
                'order',
                'requester',
                'approver',
                'refund',
            ]);
        });
    }
}
