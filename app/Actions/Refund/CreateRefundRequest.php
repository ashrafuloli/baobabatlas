<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
use App\Models\Refund;
use App\Models\RefundRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CreateRefundRequest
{
    /**
     * Create a new refund request or reuse a previously rejected request.
     *
     * Current refund architecture:
     *
     * - One refund request is allowed per order.
     * - Shipping charges are non-refundable.
     * - The customer requests the full remaining refundable amount.
     * - A rejected request can be submitted again.
     * - Partial item-level refunds are not supported by this action.
     *
     * Stock restoration is therefore handled as a full-order stock
     * restoration after Stripe successfully completes the refund.
     */
    public function execute(
        Order $order,
        User $user,
        array $data,
    ): RefundRequest {
        return DB::transaction(
            function () use (
                $order,
                $user,
                $data,
            ): RefundRequest {
                /*
                |--------------------------------------------------------------------------
                | Lock Order
                |--------------------------------------------------------------------------
                |
                | Prevent concurrent refund requests for the same order.
                |
                */

                $order = Order::query()
                    ->whereKey($order->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | Verify Order Ownership
                |--------------------------------------------------------------------------
                */

                if (
                    $order->user_id === null
                    || $order->user_id !== $user->id
                ) {
                    throw new RuntimeException(
                        'You are not authorized to request a refund for this order.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Payment Status
                |--------------------------------------------------------------------------
                |
                | Refund eligibility is based on payment status.
                |
                */

                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a refund because the payment has not been completed.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Order Total
                |--------------------------------------------------------------------------
                */

                $orderTotal = round(
                    (float) $order->total,
                    2,
                );

                $shippingAmount = round(
                    (float) $order->shipping,
                    2,
                );

                if (
                    $orderTotal <= 0
                    || $shippingAmount < 0
                ) {
                    throw new RuntimeException(
                        'The order contains invalid refund amounts.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Calculate Successfully Refunded Amount
                |--------------------------------------------------------------------------
                |
                | Only successful refunds reduce the remaining refundable
                | amount.
                |
                */

                $alreadyRefunded = round(
                    (float) $order->refunds()
                        ->where(
                            'status',
                            Refund::STATUS_SUCCEEDED,
                        )
                        ->sum('amount'),
                    2,
                );

                /*
                |--------------------------------------------------------------------------
                | Calculate Remaining Refundable Amount
                |--------------------------------------------------------------------------
                |
                | Shipping is intentionally excluded from the refundable
                | amount.
                |
                | refundable =
                |
                | order total
                | - shipping
                | - successfully refunded amount
                |
                */

                $refundableAmount = max(
                    0,
                    round(
                        $orderTotal
                        - $shippingAmount
                        - $alreadyRefunded,
                        2,
                    ),
                );

                if ($refundableAmount <= 0) {
                    throw new RuntimeException(
                        'There is no refundable amount remaining for this order.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Refund Reason
                |--------------------------------------------------------------------------
                */

                $reason = trim(
                    (string) ($data['reason'] ?? ''),
                );

                if ($reason === '') {
                    throw new RuntimeException(
                        'A refund reason is required.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Optional Customer Message
                |--------------------------------------------------------------------------
                */

                $message = isset($data['message'])
                    ? trim(
                        (string) $data['message'],
                    )
                    : null;

                if ($message === '') {
                    $message = null;
                }

                /*
                |--------------------------------------------------------------------------
                | Find Existing Refund Request
                |--------------------------------------------------------------------------
                |
                | One refund request is allowed per order.
                |
                */

                $refundRequest = RefundRequest::query()
                    ->where(
                        'order_id',
                        $order->id,
                    )
                    ->lockForUpdate()
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | Existing Refund Request
                |--------------------------------------------------------------------------
                */

                if ($refundRequest !== null) {
                    /*
                    |--------------------------------------------------------------------------
                    | Pending
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $refundRequest->status
                        === RefundRequest::STATUS_PENDING
                    ) {
                        throw new RuntimeException(
                            'A refund request is already under review.',
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Approved
                    |--------------------------------------------------------------------------
                    |
                    | The approved request should be processed by RefundOrder.
                    |
                    */

                    if (
                        $refundRequest->status
                        === RefundRequest::STATUS_APPROVED
                    ) {
                        throw new RuntimeException(
                            'This refund request has already been approved.',
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Rejected
                    |--------------------------------------------------------------------------
                    |
                    | Reuse the same row rather than creating another request.
                    |
                    */

                    if (
                        $refundRequest->status
                        === RefundRequest::STATUS_REJECTED
                    ) {
                        $refundRequest->update([
                            'requested_by' => $user->id,

                            /*
                             * Always request the full remaining refundable
                             * amount.
                             */
                            'amount' => $refundableAmount,

                            /*
                             * Admin deduction must be reset when a customer
                             * submits a rejected request again.
                             */
                            'deduction_amount' => 0,

                            'deduction_reason' => null,

                            'reason' => $reason,

                            'message' => $message,

                            'status' =>
                                RefundRequest::STATUS_PENDING,

                            'approved_by' => null,

                            'approved_at' => null,

                            'admin_note' => null,
                        ]);

                        return $refundRequest->fresh();
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Unexpected Status
                    |--------------------------------------------------------------------------
                    */

                    throw new RuntimeException(
                        'A refund request already exists for this order.',
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Create First Refund Request
                |--------------------------------------------------------------------------
                */

                return RefundRequest::query()->create([
                    'order_id' => $order->id,

                    'requested_by' => $user->id,

                    /*
                     * Full remaining refundable amount.
                     */
                    'amount' => $refundableAmount,

                    /*
                     * Admin can apply a deduction later during approval.
                     */
                    'deduction_amount' => 0,

                    'deduction_reason' => null,

                    'reason' => $reason,

                    'message' => $message,

                    'status' =>
                        RefundRequest::STATUS_PENDING,

                    'approved_by' => null,

                    'approved_at' => null,

                    'admin_note' => null,
                ]);
            },
        );
    }
}
