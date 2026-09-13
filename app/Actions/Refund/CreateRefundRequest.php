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
     * One refund request is allowed per order.
     * A rejected request can be submitted again by reusing
     * the existing refund request row.
     */
    public function execute(
        Order $order,
        User $user,
        array $data,
    ): RefundRequest {
        return DB::transaction(
            function () use ($order, $user, $data): RefundRequest {
                /*
                 * Lock the order to prevent concurrent refund requests.
                 */
                $order = Order::query()
                    ->whereKey($order->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                 * Make sure the authenticated user owns the order.
                 */
                if ($order->user_id !== $user->id) {
                    throw new RuntimeException(
                        'You are not authorized to request a refund for this order.',
                    );
                }

                /*
                 * The order must have a successful payment.
                 */
                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a refund.',
                    );
                }

                /*
                 * Refunds are available only for paid,
                 * processing, or completed orders.
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
                    throw new RuntimeException(
                        'This order is not eligible for a refund.',
                    );
                }

                /*
                 * Calculate the amount that has already been
                 * successfully refunded.
                 */
                $alreadyRefunded = (float) $order->refunds()
                    ->where('status', Refund::STATUS_SUCCEEDED)
                    ->sum('amount');

                /*
                 * Shipping is non-refundable.
                 */
                $refundableAmount = max(
                    0,
                    round(
                        (float) $order->total
                        - (float) $order->shipping
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
                 * One refund request per order.
                 *
                 * Lock the existing request so two simultaneous
                 * requests cannot modify it at the same time.
                 */
                $refundRequest = RefundRequest::query()
                    ->where('order_id', $order->id)
                    ->lockForUpdate()
                    ->first();

                /*
                 * Existing refund request found.
                 */
                if ($refundRequest !== null) {
                    /*
                     * A pending request is already under review.
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
                     * An approved request cannot be submitted again.
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
                     * A rejected request can be submitted again.
                     *
                     * Reuse the same database row instead of creating
                     * another refund request for this order.
                     */
                    if (
                        $refundRequest->status
                        === RefundRequest::STATUS_REJECTED
                    ) {
                        $refundRequest->update([
                            'requested_by' => $user->id,
                            'amount' => $refundableAmount,
                            'deduction_amount' => 0,
                            'deduction_reason' => null,
                            'reason' => $data['reason'],
                            'message' => $data['message'] ?? null,
                            'status' => RefundRequest::STATUS_PENDING,
                            'approved_by' => null,
                            'approved_at' => null,
                            'admin_note' => null,
                        ]);

                        return $refundRequest->fresh();
                    }

                    /*
                     * Safety fallback for any unexpected status.
                     */
                    throw new RuntimeException(
                        'A refund request already exists for this order.',
                    );
                }

                /*
                 * First refund request for this order.
                 */
                return RefundRequest::query()->create([
                    'order_id' => $order->id,
                    'requested_by' => $user->id,
                    'amount' => $refundableAmount,
                    'deduction_amount' => 0,
                    'deduction_reason' => null,
                    'reason' => $data['reason'],
                    'message' => $data['message'] ?? null,
                    'status' => RefundRequest::STATUS_PENDING,
                    'approved_by' => null,
                    'approved_at' => null,
                    'admin_note' => null,
                ]);
            },
        );
    }
}
