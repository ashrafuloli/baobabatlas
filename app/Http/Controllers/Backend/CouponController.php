<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class CouponController extends Controller
{
    public function index(): View
    {
        $coupons = Coupon::query()
            ->withCount('products')
            ->latest()
            ->paginate(15);

        return view(
            'backend.pages.ecommerce.coupons.index',
            compact('coupons')
        );
    }

    public function create(): View
    {
        $products = Product::query()
            ->where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'sku',
                'thumbnail',
                'price',
            ]);

        return view(
            'backend.pages.ecommerce.coupons.create',
            compact('products')
        );
    }

    public function store(
        StoreCouponRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $productIds = $validated['product_ids'] ?? [];

        unset($validated['product_ids']);

        $coupon = Coupon::query()->create($validated);

        if (!empty($productIds)) {
            $coupon->products()->sync($productIds);
        }

        return redirect()
            ->route('admin-coupons')
            ->with(
                'success',
                'Promo code has been created successfully.'
            );
    }

    public function edit(
        Coupon $coupon
    ): View {
        $coupon->load('products');

        $products = Product::query()
            ->where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'sku',
                'thumbnail',
                'price',
            ]);

        $selectedProductIds = $coupon->products
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        return view(
            'backend.pages.ecommerce.coupons.edit',
            compact(
                'coupon',
                'products',
                'selectedProductIds'
            )
        );
    }

    public function update(
        UpdateCouponRequest $request,
        Coupon $coupon
    ): RedirectResponse {
        $validated = $request->validated();

        $productIds = $validated['product_ids'] ?? [];

        unset($validated['product_ids']);

        $coupon->update($validated);

        /*
         * Empty product_ids means the coupon applies
         * to all products.
         */
        $coupon->products()->sync($productIds);

        return redirect()
            ->route('admin-coupons')
            ->with(
                'success',
                'Promo code has been updated successfully.'
            );
    }

    public function destroy(
        Coupon $coupon
    ): RedirectResponse {
        $coupon->delete();

        return redirect()
            ->route('admin-coupons')
            ->with(
                'success',
                'Promo code has been deleted successfully.'
            );
    }
}
