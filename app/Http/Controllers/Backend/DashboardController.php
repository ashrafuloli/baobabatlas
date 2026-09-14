<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SmartBuyRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

final class DashboardController extends Controller
{
    public function customer(): View
    {
        $user = Auth::user();

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->get([
                'id',
                'order_number',
                'status',
                'payment_status',
                'total',
                'currency',
                'created_at',
            ]);

        $stats = [
            'total_orders' => $orders->count(),
            'completed_orders' => $orders
                ->where('status', Order::STATUS_COMPLETED)
                ->count(),
            'pending_orders' => $orders
                ->where('status', Order::STATUS_PENDING)
                ->count(),
            'total_spent' => (float) $orders
                ->where(
                    'payment_status',
                    Order::PAYMENT_STATUS_PAID,
                )
                ->sum(
                    static fn (Order $order): float => (float) $order->total,
                ),
        ];

        $recentOrders = $orders->take(5);

        $recentSmartBuyRequests = SmartBuyRequest::query()
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->withCount('items')
            ->take(5)
            ->get([
                'id',
                'request_number',
                'status',
                'created_at',
            ]);

        return view(
            'backend.pages.dashboard.customer',
            [
                'user' => $user,
                'stats' => $stats,
                'recentOrders' => $recentOrders,
                'recentSmartBuyRequests' => $recentSmartBuyRequests,
            ],
        );
    }

    public function admin(): View
    {
        $totalOrders = Order::query()->count();

        $totalRevenue = (float) Order::query()
            ->where(
                'payment_status',
                Order::PAYMENT_STATUS_PAID,
            )
            ->sum('total');

        $pendingOrders = Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->count();

        $completedOrders = Order::query()
            ->where('status', Order::STATUS_COMPLETED)
            ->count();

        $totalCustomers = User::query()
            ->whereDoesntHave(
                'roles',
                static function ($query): void {
                    $query->where('slug', 'admin');
                },
            )
            ->count();

        $totalProducts = Product::query()->count();

        $totalSmartBuyRequests = SmartBuyRequest::query()->count();

        $pendingSmartBuyRequests = SmartBuyRequest::query()
            ->where(
                'status',
                SmartBuyRequest::STATUS_PENDING,
            )
            ->count();

        $recentOrders = Order::query()
            ->latest('created_at')
            ->take(8)
            ->get([
                'id',
                'order_number',
                'status',
                'payment_status',
                'total',
                'currency',
                'created_at',
            ]);

        $recentSmartBuyRequests = SmartBuyRequest::query()
            ->latest('created_at')
            ->withCount('items')
            ->take(8)
            ->get([
                'id',
                'user_id',
                'request_number',
                'status',
                'created_at',
            ]);

        return view(
            'backend.pages.dashboard.admin',
            [
                'stats' => [
                    'total_orders' => $totalOrders,
                    'total_revenue' => $totalRevenue,
                    'pending_orders' => $pendingOrders,
                    'completed_orders' => $completedOrders,
                    'total_customers' => $totalCustomers,
                    'total_products' => $totalProducts,
                    'total_smart_buy_requests' => $totalSmartBuyRequests,
                    'pending_smart_buy_requests' => $pendingSmartBuyRequests,
                ],
                'recentOrders' => $recentOrders,
                'recentSmartBuyRequests' => $recentSmartBuyRequests,
            ],
        );
    }
}
