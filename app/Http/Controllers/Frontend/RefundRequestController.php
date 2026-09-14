<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Refund\CreateRefundRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\RefundRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Throwable;

final class RefundRequestController extends Controller
{
    public function store(
        RefundRequest $request,
        Order $order,
        CreateRefundRequest $createRefundRequest
    ): RedirectResponse {
        if ($order->user_id !== $request->user()->id) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'You are not authorized to request a refund for this order.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Refund Eligibility
        |--------------------------------------------------------------------------
        |
        | Refund is allowed when the payment has been successfully paid.
        | Order status does not control refund eligibility.
        |
        */

        if ($order->payment_status !== Order::PAYMENT_STATUS_PAID) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'A refund can only be requested for a paid order.'
                );
        }

        try {
            $createRefundRequest->execute(
                order: $order,
                user: $request->user(),
                data: $request->validated(),
            );
        } catch (Throwable $exception) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    $exception->getMessage()
                );
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Your refund request has been submitted successfully.'
            );
    }
}
