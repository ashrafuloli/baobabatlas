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
            'backend.pages.ecommerce.admin.orders.index',
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
            'items',
        ]);

        return view(
            'backend.pages.ecommerce.admin.orders.details',
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

        DB::transaction(function () use ($order, $validated): void {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            $newStatus = $validated['status'];

            if (
                $newStatus === Order::STATUS_PAID
                && $lockedOrder->payment_status !== Order::PAYMENT_STATUS_PAID
            ) {
                abort(
                    422,
                    'The order cannot be marked as paid before the payment is confirmed.',
                );
            }

            if ($lockedOrder->status === Order::STATUS_CANCELLED) {
                abort(
                    422,
                    'A cancelled order cannot be changed.',
                );
            }

            if ($lockedOrder->status === Order::STATUS_COMPLETED) {
                abort(
                    422,
                    'A completed order cannot be changed.',
                );
            }

            $lockedOrder->update([
                'status' => $newStatus,
            ]);
        });

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
}
