<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Wishlist\AddProductToWishlist;
use App\Actions\Wishlist\RemoveProductFromWishlist;
use App\Actions\Wishlist\ToggleWishlist;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlist = Wishlist::query()
            ->where('user_id', $request->user()->id)
            ->with([
                'items.product.brand',
                'items.product.images',
                'items.product.variants',
            ])
            ->first();

        return view('frontend.pages.shop.my-wishlist', [
            'wishlist' => $wishlist,
            'items' => $wishlist?->items ?? collect(),
        ]);
    }

    public function add(
        Request $request,
        Product $product,
        AddProductToWishlist $addProductToWishlist,
    ): RedirectResponse|JsonResponse {
        $addProductToWishlist->execute(
            $request->user()->id,
            $product->id,
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'wishlisted' => true,
                'message' => 'Product added to your wishlist.',
            ]);
        }

        return back()->with(
            'success',
            'Product added to your wishlist.',
        );
    }

    public function remove(
        Request $request,
        Product $product,
        RemoveProductFromWishlist $removeProductFromWishlist,
    ): RedirectResponse|JsonResponse {
        $removed = $removeProductFromWishlist->execute(
            $request->user()->id,
            $product->id,
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => $removed,
                'wishlisted' => false,
                'message' => $removed
                    ? 'Product removed from your wishlist.'
                    : 'Product was not found in your wishlist.',
            ], $removed ? 200 : 404);
        }

        if ($removed) {
            return back()->with(
                'success',
                'Product removed from your wishlist.',
            );
        }

        return back()->with(
            'info',
            'Product was not found in your wishlist.',
        );
    }

    public function toggle(
        Request $request,
        Product $product,
        ToggleWishlist $toggleWishlist,
    ): JsonResponse {
        $wishlisted = $toggleWishlist->execute(
            $request->user()->id,
            $product->id,
        );

        return response()->json([
            'success' => true,
            'wishlisted' => $wishlisted,
            'message' => $wishlisted
                ? 'Product added to your wishlist.'
                : 'Product removed from your wishlist.',
        ]);
    }
}
