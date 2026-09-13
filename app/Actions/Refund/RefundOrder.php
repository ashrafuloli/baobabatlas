<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\Order;
use App\Models\Refund;
use App\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

final class RefundOrder
{
    public function execute(
        RefundRequest $refundRequest,
    ): Refund {
        return DB::transaction(
            function () use ($refundRequest): Refund {
                $refundRequest = RefundRequest::query()
                    ->whereKey($refundRequest->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $refundRequest->status
                    !== RefundRequest::STATUS_APPROVED
                ) {
                    throw new RuntimeException(
                        'Only an approved refund request can be processed.',
                    );
                }

                $order = Order::query()
                    ->whereKey($refundRequest->order_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    $order->payment_status
                    !== Order::PAYMENT_STATUS_PAID
                ) {
                    throw new RuntimeException(
                        'This order is not eligible for a Stripe refund.',
                    );
                }

                if (
                    ! filled($order->stripe_payment_intent_id)
                ) {
                    throw new RuntimeException(
                        'The Stripe payment intent is missing.',
                    );
                }

                $existingRefund = Refund::query()
                    ->where(
                        'refund_request_id',
                        $refundRequest->id,
                    )
                    ->first();

                if ($existingRefund !== null) {
                    return $existingRefund;
                }

                $successfulRefundedAmount = (float) $order->refunds()
                    ->where(
                        'status',
                        Refund::STATUS_SUCCEEDED,
                    )
                    ->sum('amount');

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

                $requestedRefundAmount = min(
                    round(
                        (float) $refundRequest->amount,
                        2,
                    ),
                    $remainingRefundableAmount,
                );

                $deductionAmount = max(
                    0,
                    round(
                        (float) $refundRequest->deduction_amount,
                        2,
                    ),
                );

                if ($deductionAmount > $requestedRefundAmount) {
                    throw new RuntimeException(
                        'The deduction amount cannot exceed the refundable amount.',
                    );
                }

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

                $stripeSecret = config(
                    'services.stripe.secret',
                );

                if (
                    ! is_string($stripeSecret)
                    || $stripeSecret === ''
                ) {
                    throw new RuntimeException(
                        'Stripe secret key is not configured.',
                    );
                }

                $stripe = new StripeClient(
                    $stripeSecret,
                );

                try {
                    $stripeRefund = $stripe->refunds->create(
                        [
                            'payment_intent' =>
                                $order->stripe_payment_intent_id,

                            'amount' => (int) round(
                                $finalRefundAmount * 100,
                            ),
                        ],
                        [
                            'idempotency_key' =>
                                'refund-request-'
                                . $refundRequest->id,
                        ],
                    );
                } catch (ApiErrorException $exception) {
                    report($exception);

                    throw new RuntimeException(
                        'Stripe refund failed: '
                        . $exception->getMessage(),
                        previous: $exception,
                    );
                }

                $refund = Refund::query()->create([
                    'order_id' => $order->id,
                    'refund_request_id' => $refundRequest->id,
                    'stripe_refund_id' => $stripeRefund->id,
                    'amount' => $finalRefundAmount,
                    'currency' => strtolower(
                        (string) $order->currency,
                    ),
                    'status' => $stripeRefund->status,
                ]);

                if (
                    $stripeRefund->status
                    === Refund::STATUS_SUCCEEDED
                ) {
                    $order->update([
                        'refund_status' =>
                            Order::REFUND_STATUS_REFUNDED,
                    ]);
                }

                return $refund->fresh();
            },
        );
    }
}
