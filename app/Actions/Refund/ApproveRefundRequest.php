<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class ApproveRefundRequest
{
    public function execute(
        RefundRequest $refundRequest,
        int $approvedBy,
    ): RefundRequest {
        return DB::transaction(function () use (
            $refundRequest,
            $approvedBy,
        ): RefundRequest {
            $refundRequest = RefundRequest::query()
                ->whereKey($refundRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * =========================================================
             * Validate Refund Request
             * =========================================================
             */

            if (
                $refundRequest->status
                !== RefundRequest::STATUS_PENDING
            ) {
                throw ValidationException::withMessages([
                    'refund' => 'This refund request has already been processed.',
                ]);
            }

            /*
             * =========================================================
             * Lock Order
             * =========================================================
             */

            $order = Order::query()
                ->whereKey($refundRequest->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * =========================================================
             * Validate Payment
             * =========================================================
             *
             * Refund approval depends only on payment status.
             *
             * Order status does not restrict refund approval.
             */

            if (
                $order->payment_status
                !== Order::PAYMENT_STATUS_PAID
            ) {
                throw ValidationException::withMessages([
                    'refund' => 'Only paid orders can be approved for a refund.',
                ]);
            }

            /*
             * =========================================================
             * Approve Refund Request
             * =========================================================
             */

            $refundRequest->update([
                'status' => RefundRequest::STATUS_APPROVED,
                'approved_by' => $approvedBy,
                'approved_at' => now(),
            ]);

            /*
             * =========================================================
             * Update Order Refund Status
             * =========================================================
             *
             * The order can be in any status as long as the payment
             * has been successfully completed.
             *
             * Once the refund request is approved, the order is
             * cancelled and marked as refund approved.
             */

            $order->update([
                'status' => Order::STATUS_CANCELLED,
                'refund_status' => Order::REFUND_STATUS_APPROVED,
            ]);

            /*
             * =========================================================
             * Return Fresh Refund Request
             * =========================================================
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
