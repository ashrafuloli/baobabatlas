<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Checkout\CreateStripeCheckoutSession;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with([
                'items.product.categories',
                'items.variant.values.attribute',
            ])
            ->withCount('items')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'frontend.pages.shop.my-orders',
            [
                'orders' => $orders,
            ],
        );
    }

    public function show(
        Request $request,
        Order $order,
    ): View {
        abort_unless(
            $order->user_id === $request->user()->id,
            404,
        );

        $order->load([
            'items.product.categories',
            'items.variant.values.attribute',
            'refundRequests.requester',
            'refundRequests.approver',
            'refundRequests.refund',
            'refunds',
        ]);

        return view(
            'frontend.pages.shop.order-details',
            [
                'order' => $order,
            ],
        );
    }

    public function payment(
        Request $request,
        Order $order,
        CreateStripeCheckoutSession $createStripeCheckoutSession,
    ): RedirectResponse {
        abort_unless(
            $order->user_id === $request->user()->id,
            403,
        );

        if (
            $order->status !== Order::STATUS_PENDING
            || $order->payment_status !== Order::PAYMENT_STATUS_PENDING
        ) {
            return redirect()
                ->route('my-orders.show', $order)
                ->with(
                    'error',
                    'This order is no longer available for payment.',
                );
        }

        $session = $createStripeCheckoutSession->execute($order);

        if (
            !is_string($session->url)
            || trim($session->url) === ''
        ) {
            return redirect()
                ->route('my-orders.show', $order)
                ->with(
                    'error',
                    'Unable to start the payment process. Please try again.',
                );
        }

        return redirect()->away($session->url);
    }

    public function cancel(
        Request $request,
        Order $order,
    ): RedirectResponse {
        abort_unless(
            $order->user_id === $request->user()->id,
            403,
        );

        DB::transaction(function () use ($order): void {
            $lockedOrder = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $lockedOrder->status !== Order::STATUS_PENDING
                || $lockedOrder->payment_status !== Order::PAYMENT_STATUS_PENDING
            ) {
                return;
            }

            $lockedOrder->update([
                'status' => Order::STATUS_CANCELLED,
            ]);
        });

        return redirect()
            ->route('my-orders.show', $order)
            ->with(
                'success',
                'Your order has been cancelled successfully.',
            );
    }
}
