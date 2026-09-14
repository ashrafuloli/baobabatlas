<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
use App\Models\Refund;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

final class RefundOrder
{
    public function execute(
        RefundRequest $refundRequest,
    ): Refund {
        $refund = DB::transaction(
            function () use ($refundRequest): Refund {
                /*
                 * Lock the refund request to prevent concurrent
                 * refund processing.
                 */
                $refundRequest = RefundRequest::query()
                    ->whereKey($refundRequest->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                 * Only approved refund requests can be processed.
                 */
                if (
                    $refundRequest->status
                    !== RefundRequest::STATUS_APPROVED
                ) {
                    throw new RuntimeException(
                        'Only an approved refund request can be processed.',
                    );
                }

                /*
                 * Lock the order to prevent concurrent refund
                 * operations against the same payment.
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
                 * Refund processing depends only on payment status.
                 *
                 * Order status does not restrict the refund.
                 */
                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a Stripe refund because the payment has not been completed.',
                    );
                }

                /*
                 * Stripe Payment Intent is required to create
                 * the refund.
                 */
                if (
                    ! filled($order->stripe_payment_intent_id)
                ) {
                    throw new RuntimeException(
                        'The Stripe payment intent is missing.',
                    );
                }

                /*
                 * =========================================================
                 * Check Existing Refund
                 * =========================================================
                 *
                 * One local Refund record is associated with one
                 * RefundRequest.
                 */
                $existingRefund = Refund::query()
                    ->where(
                        'refund_request_id',
                        $refundRequest->id,
                    )
                    ->lockForUpdate()
                    ->first();

                if ($existingRefund !== null) {
                    /*
                     * Refund already succeeded.
                     */
                    if ($existingRefund->isSucceeded()) {
                        return $existingRefund;
                    }

                    /*
                     * Stripe already returned a refund ID.
                     *
                     * Never create another Stripe refund.
                     */
                    if (filled($existingRefund->stripe_refund_id)) {
                        return $existingRefund;
                    }

                    /*
                     * Existing pending/failed refund without a Stripe ID
                     * can be retried outside this transaction using the
                     * same persisted idempotency key and amount.
                     */
                    return $existingRefund;
                }

                /*
                 * =========================================================
                 * Calculate Refundable Amount
                 * =========================================================
                 */

                $successfulRefundedAmount = (float) $order->refunds()
                    ->where(
                        'status',
                        Refund::STATUS_SUCCEEDED,
                    )
                    ->sum('amount');

                /*
                 * Shipping charges are non-refundable.
                 */
                $remainingRefundableAmount = max(
                    0,
                    round(
                        (float) $order->total
                        - (float) $order->shipping
                        - $successfulRefundedAmount,
                        2,
                    ),
                );

                if ($remainingRefundableAmount <= 0) {
                    throw new RuntimeException(
                        'There is no refundable amount remaining for this order.',
                    );
                }

                /*
                 * Never refund more than the remaining refundable amount.
                 */
                $requestedRefundAmount = min(
                    round(
                        (float) $refundRequest->amount,
                        2,
                    ),
                    $remainingRefundableAmount,
                );

                /*
                 * Apply any admin-approved deduction.
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
                    > $requestedRefundAmount
                ) {
                    throw new RuntimeException(
                        'The deduction amount cannot exceed the refundable amount.',
                    );
                }

                /*
                 * Final amount that will actually be sent to Stripe.
                 */
                $finalRefundAmount = round(
                    $requestedRefundAmount
                    - $deductionAmount,
                    2,
                );

                if ($finalRefundAmount <= 0) {
                    throw new RuntimeException(
                        'There is no refundable amount remaining after the deduction.',
                    );
                }

                /*
                 * =========================================================
                 * Create Local Refund Record
                 * =========================================================
                 *
                 * The refund record is created BEFORE communicating
                 * with Stripe.
                 *
                 * This permanently stores:
                 *
                 * - refund amount
                 * - currency
                 * - Stripe idempotency key
                 * - refund request relationship
                 *
                 * The same idempotency key will be used if the Stripe
                 * request needs to be retried.
                 */
                return Refund::query()->create([
                    'order_id' => $order->id,
                    'refund_request_id' => $refundRequest->id,
                    'stripe_refund_id' => null,
                    'stripe_idempotency_key' => Str::uuid()->toString(),
                    'amount' => $finalRefundAmount,
                    'currency' => strtolower(
                        (string) $order->currency,
                    ),
                    'status' => Refund::STATUS_PENDING,
                ]);
            },
        );

        /*
         * =============================================================
         * Already Successfully Refunded
         * =============================================================
         */

        if ($refund->isSucceeded()) {
            return $refund->fresh();
        }

        /*
         * =============================================================
         * Stripe Refund Already Exists
         * =============================================================
         *
         * If Stripe has already returned a refund ID, never create
         * another refund.
         */
        if (filled($refund->stripe_refund_id)) {
            return $refund->fresh();
        }

        /*
         * =============================================================
         * Load Order
         * =============================================================
         */

        $order = $refund->order()->firstOrFail();

        /*
         * =============================================================
         * Stripe Configuration
         * =============================================================
         */

        $stripeSecret = config('services.stripe.secret');

        if (
            ! is_string($stripeSecret)
            || $stripeSecret === ''
        ) {
            $this->markAsFailed(
                $refund->id,
            );

            throw new RuntimeException(
                'Stripe secret key is not configured.',
            );
        }

        $stripe = new StripeClient($stripeSecret);

        /*
         * =============================================================
         * Create Stripe Refund
         * =============================================================
         */

        try {
            $stripeRefund = $stripe->refunds->create(
                [
                    'payment_intent' =>
                        $order->stripe_payment_intent_id,

                    'amount' => (int) round(
                        (float) $refund->amount * 100,
                    ),
                ],
                [
                    /*
                     * IMPORTANT:
                     *
                     * The idempotency key was generated once and
                     * persisted in the Refund record.
                     *
                     * Retries must use the exact same key.
                     */
                    'idempotency_key' =>
                        $refund->stripe_idempotency_key,
                ],
            );
        } catch (ApiErrorException $exception) {
            report($exception);

            $this->markAsFailed(
                $refund->id,
            );

            throw new RuntimeException(
                'Stripe refund failed: '
                . $exception->getMessage(),
                previous: $exception,
            );
        }

        /*
         * =============================================================
         * Store Stripe Result
         * =============================================================
         */

        return DB::transaction(
            function () use (
                $refund,
                $stripeRefund,
            ): Refund {
                $refund = Refund::query()
                    ->whereKey($refund->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                /*
                 * Another request may have completed this refund while
                 * the current request was communicating with Stripe.
                 */
                if (
                    $refund->isSucceeded()
                    && filled($refund->stripe_refund_id)
                ) {
                    return $refund;
                }

                /*
                 * Store Stripe's refund ID and current status.
                 */
                $refund->update([
                    'stripe_refund_id' => $stripeRefund->id,
                    'status' => $stripeRefund->status,
                ]);

                /*
                 * Stripe successfully refunded the payment.
                 *
                 * At this point the Order is marked as refunded.
                 */
                if (
                    $stripeRefund->status
                    === Refund::STATUS_SUCCEEDED
                ) {
                    $order = $refund->order()
                        ->lockForUpdate()
                        ->firstOrFail();

                    $order->update([
                        'refund_status' =>
                            Order::REFUND_STATUS_REFUNDED,
                    ]);
                }

                return $refund->fresh();
            },
        );
    }

    /**
     * Mark a local refund as failed.
     */
    private function markAsFailed(
        int $refundId,
    ): void {
        DB::transaction(
            function () use ($refundId): void {
                Refund::query()
                    ->whereKey($refundId)
                    ->lockForUpdate()
                    ->update([
                        'status' => Refund::STATUS_FAILED,
                    ]);
            },
        );
    }
}
