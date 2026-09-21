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
            /*
            |--------------------------------------------------------------------------
            | Lock Refund Request
            |--------------------------------------------------------------------------
            |
            | Prevent two admins from approving the same request at the
            | same time.
            |
            */

            $refundRequest = RefundRequest::query()
                ->whereKey($refundRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Validate Refund Request
            |--------------------------------------------------------------------------
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
            |--------------------------------------------------------------------------
            | Lock Order
            |--------------------------------------------------------------------------
            */

            $order = Order::query()
                ->whereKey($refundRequest->order_id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Validate Payment
            |--------------------------------------------------------------------------
            |
            | Refund approval is only possible after successful payment.
            |
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
            |--------------------------------------------------------------------------
            | Validate Refund Amount
            |--------------------------------------------------------------------------
            */

            $requestedAmount = round(
                (float) $refundRequest->amount,
                2,
            );

            if ($requestedAmount <= 0) {
                throw ValidationException::withMessages([
                    'refund' => 'The refund amount must be greater than zero.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Calculate Successfully Refunded Amount
            |--------------------------------------------------------------------------
            */

            $alreadyRefunded = round(
                (float) $order->refunds()
                    ->where(
                        'status',
                        \App\Models\Refund::STATUS_SUCCEEDED,
                    )
                    ->sum('amount'),
                2,
            );

            /*
            |--------------------------------------------------------------------------
            | Calculate Remaining Refundable Amount
            |--------------------------------------------------------------------------
            |
            | Shipping is non-refundable.
            |
            */

            $remainingRefundableAmount = max(
                0,
                round(
                    (float) $order->total
                    - (float) $order->shipping
                    - $alreadyRefunded,
                    2,
                ),
            );

            if ($remainingRefundableAmount <= 0) {
                throw ValidationException::withMessages([
                    'refund' => 'There is no refundable amount remaining for this order.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent Over-Approval
            |--------------------------------------------------------------------------
            */

            if (
                $requestedAmount
                > $remainingRefundableAmount
            ) {
                throw ValidationException::withMessages([
                    'refund' => sprintf(
                        'The requested refund amount cannot exceed the remaining refundable amount of %s.',
                        number_format(
                            $remainingRefundableAmount,
                            2,
                        ),
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Deduction
            |--------------------------------------------------------------------------
            */

            $deductionAmount = max(
                0,
                round(
                    (float) $refundRequest->deduction_amount,
                    2,
                ),
            );

            if (
                $deductionAmount
                > $requestedAmount
            ) {
                throw ValidationException::withMessages([
                    'refund' => 'The deduction amount cannot exceed the requested refund amount.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Approve Refund Request
            |--------------------------------------------------------------------------
            */

            $refundRequest->update([
                'status' => RefundRequest::STATUS_APPROVED,

                'approved_by' => $approvedBy,

                'approved_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Order Refund Status
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            |
            | Do NOT restore stock here.
            |
            | Approval only means that the admin has authorized the refund.
            |
            | Actual stock restoration happens in RefundOrder only after
            | Stripe confirms the refund successfully.
            |
            */

            $order->update([
                'status' => Order::STATUS_CANCELLED,

                'refund_status' =>
                    Order::REFUND_STATUS_APPROVED,
            ]);

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
