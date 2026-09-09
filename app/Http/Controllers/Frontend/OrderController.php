<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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

    public function show(Request $request, Order $order): View
    {
        abort_unless(
            $order->user_id === $request->user()->id,
            404,
        );

        $order->load([
            'items.product.categories',
            'items.variant.values.attribute',
        ]);

        return view(
            'frontend.pages.shop.order-details',
            [
                'order' => $order,
            ],
        );
    }
}
