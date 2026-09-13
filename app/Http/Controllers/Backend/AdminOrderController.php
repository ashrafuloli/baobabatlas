<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = trim((string) $request->input('status'));
        $paymentStatus = trim((string) $request->input('payment_status'));
        $date = trim((string) $request->input('date'));

        $baseQuery = Order::query();

        $orders = (clone $baseQuery)
            ->with('user')
            ->withCount('items')
            ->when(
                $search !== '',
                function (Builder $query) use ($search): void {
                    $query->where(function (Builder $query) use ($search): void {
                        $query
                            ->where(
                                'order_number',
                                'like',
                                '%' . $search . '%',
                            )
                            ->orWhere(
                                'first_name',
                                'like',
                                '%' . $search . '%',
                            )
                            ->orWhere(
                                'last_name',
                                'like',
                                '%' . $search . '%',
                            )
                            ->orWhere(
                                'email',
                                'like',
                                '%' . $search . '%',
                            );
                    });
                },
            )
            ->when(
                $status !== '',
                function (Builder $query) use ($status): void {
                    $query->where('status', $status);
                },
            )
            ->when(
                $paymentStatus !== '',
                function (Builder $query) use ($paymentStatus): void {
                    $query->where('payment_status', $paymentStatus);
                },
            )
            ->when(
                $date !== '',
                function (Builder $query) use ($date): void {
                    match ($date) {
                        'today' => $query->whereDate(
                            'created_at',
                            now()->toDateString(),
                        ),

                        'week' => $query->where(
                            'created_at',
                            '>=',
                            now()->startOfWeek(),
                        ),

                        'month' => $query->where(
                            'created_at',
                            '>=',
                            now()->startOfMonth(),
                        ),

                        'year' => $query->where(
                            'created_at',
                            '>=',
                            now()->startOfYear(),
                        ),

                        default => null,
                    };
                },
            )
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $totalOrders = (clone $baseQuery)->count();

        $pendingOrders = (clone $baseQuery)
            ->where('status', Order::STATUS_PENDING)
            ->count();

        $processingOrders = (clone $baseQuery)
            ->where('status', Order::STATUS_PROCESSING)
            ->count();

        $completedOrders = (clone $baseQuery)
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        return view(
            'backend.pages.ecommerce.orders.index',
            [
                'orders' => $orders,
                'search' => $search,
                'status' => $status,
                'paymentStatus' => $paymentStatus,
                'date' => $date,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $pendingOrders,
                'processingOrders' => $processingOrders,
                'completedOrders' => $completedOrders,
                'orderStatuses' => [
                    Order::STATUS_PENDING,
                    Order::STATUS_PAID,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_COMPLETED,
                    Order::STATUS_CANCELLED,
                    Order::STATUS_FAILED,
                ],
                'paymentStatuses' => [
                    Order::PAYMENT_STATUS_PENDING,
                    Order::PAYMENT_STATUS_PAID,
                    Order::PAYMENT_STATUS_FAILED,
                    Order::PAYMENT_STATUS_REFUNDED,
                ],
            ],
        );
    }

    public function show(Order $order): View
    {
        $order->load([
            'user',
            'items.product',
            'items.variant.values.attribute',
            'shipment',
            'messages.user',
            'messages.orderItem',
            'refundRequests.requester',
            'refundRequests.approver',
            'refundRequests.refund',
            'refunds',
        ]);

        return view(
            'backend.pages.ecommerce.orders.details',
            compact('order'),
        );
    }

    public function updateStatus(
        Request $request,
        Order $order,
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:' . implode(',', [
                    Order::STATUS_PENDING,
                    Order::STATUS_PAID,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_COMPLETED,
                    Order::STATUS_CANCELLED,
                    Order::STATUS_FAILED,
                ]),
            ],
        ]);

        $blockedMessage = null;

        DB::transaction(function () use (
            $order,
            $validated,
            &$blockedMessage,
        ): void {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            $newStatus = $validated['status'];

            if (
                $newStatus === Order::STATUS_PAID
                && $lockedOrder->payment_status !== Order::PAYMENT_STATUS_PAID
            ) {
                $blockedMessage = 'The order cannot be marked as paid before the payment is confirmed.';

                return;
            }

            if ($lockedOrder->status === Order::STATUS_CANCELLED) {
                $blockedMessage = 'A cancelled order cannot be changed.';

                return;
            }

            if ($lockedOrder->status === Order::STATUS_COMPLETED) {
                $blockedMessage = 'A completed order cannot be changed.';

                return;
            }

            $lockedOrder->update([
                'status' => $newStatus,
            ]);
        });

        if ($blockedMessage !== null) {
            return redirect()
                ->back()
                ->with('error', $blockedMessage);
        }

        return redirect()
            ->route(
                'admin-order-details',
                ['order' => $order],
            )
            ->with(
                'success',
                'Order status updated successfully.',
            );
    }

    public function cancel(Order $order): RedirectResponse
    {
        $blockedMessage = null;

        DB::transaction(function () use (
            $order,
            &$blockedMessage,
        ): void {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($lockedOrder->status === Order::STATUS_CANCELLED) {
                $blockedMessage = 'The order is already cancelled.';

                return;
            }

            if ($lockedOrder->status === Order::STATUS_COMPLETED) {
                $blockedMessage = 'A completed order cannot be cancelled.';

                return;
            }

            if (
                $lockedOrder->payment_status !== Order::PAYMENT_STATUS_PENDING
            ) {
                $blockedMessage = 'A paid or otherwise processed order cannot be cancelled from here.';

                return;
            }

            if ($lockedOrder->status !== Order::STATUS_PENDING) {
                $blockedMessage = 'Only pending orders can be cancelled.';

                return;
            }

            $lockedOrder->update([
                'status' => Order::STATUS_CANCELLED,
            ]);
        });

        if ($blockedMessage !== null) {
            return redirect()
                ->back()
                ->with('error', $blockedMessage);
        }

        return redirect()
            ->route(
                'admin-order-details',
                ['order' => $order],
            )
            ->with(
                'success',
                'Order cancelled successfully.',
            );
    }
}
