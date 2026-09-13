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

            if (
                $refundRequest->status
                !== RefundRequest::STATUS_PENDING
            ) {
                throw ValidationException::withMessages([
                    'refund' => 'This refund request has already been processed.',
                ]);
            }

            $order = Order::query()
                ->whereKey($refundRequest->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * =========================================================
             * Validate Payment
             * =========================================================
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
             * Validate Order Status
             * =========================================================
             */

            if (
                ! in_array(
                    $order->status,
                    [
                        Order::STATUS_PAID,
                        Order::STATUS_PROCESSING,
                        Order::STATUS_COMPLETED,
                    ],
                    true,
                )
            ) {
                throw ValidationException::withMessages([
                    'refund' => 'This order is not eligible for refund approval.',
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
             * Cancel Order + Update Refund Status
             * =========================================================
             */

            $order->update([
                'status' => Order::STATUS_CANCELLED,
                'refund_status' => Order::REFUND_STATUS_APPROVED,
            ]);

            return $refundRequest->fresh([
                'order',
                'requester',
                'approver',
                'refund',
            ]);
        });
    }
}
