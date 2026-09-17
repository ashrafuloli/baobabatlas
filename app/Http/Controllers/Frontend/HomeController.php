<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => function ($query): void {
                    $query
                        ->where('status', true)
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Featured Latest Products
        |--------------------------------------------------------------------------
        */

        $latestProducts = Product::query()
            ->active()
            ->featured()
            ->with([
                'brand',
                'categories',
                'variants',
            ])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Wishlist
        |--------------------------------------------------------------------------
        */

        $wishlistProductIds = [];

        if (auth()->check()) {
            $wishlistProductIds = WishlistItem::query()
                ->whereHas(
                    'wishlist',
                    function ($query): void {
                        $query->where(
                            'user_id',
                            auth()->id(),
                        );
                    },
                )
                ->whereIn(
                    'product_id',
                    $latestProducts->pluck('id'),
                )
                ->pluck('product_id')
                ->map(
                    static fn ($productId): int => (int) $productId,
                )
                ->all();
        }


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.pages.home.index',
            compact(
                'categories',
                'latestProducts',
                'wishlistProductIds',
            ),
        );
    }
}
