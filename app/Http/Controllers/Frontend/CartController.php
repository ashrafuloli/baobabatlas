<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Cart\AddItemToCart;
use App\Actions\Cart\ClearCart;
use App\Actions\Cart\RemoveCartItem;
use App\Actions\Cart\UpdateCartItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->resolveCart($request);

        $cart->load([
            'items' => function ($query): void {
                $query->orderBy('id');
            },
            'items.product.brand',
            'items.product.categories',
            'items.product.images' => function ($query): void {
                $query
                    ->whereNull('variant_id')
                    ->orderByDesc('is_primary')
                    ->orderBy('sort_order');
            },
            'items.variant.values.attribute',
            'items.variant.values.attributeValue',
            'items.variant.images' => function ($query): void {
                $query
                    ->orderByDesc('is_primary')
                    ->orderBy('sort_order');
            },
        ]);

        return view(
            'frontend.pages.shop.cart',
            compact('cart'),
        );
    }

    public function store(
        AddToCartRequest $request,
        AddItemToCart $addItemToCart,
    ): JsonResponse {
        $product = Product::query()
            ->active()
            ->findOrFail(
                $request->integer('product_id'),
            );

        $variant = null;

        if ($request->filled('variant_id')) {
            $variant = ProductVariant::query()
                ->whereKey(
                    $request->integer('variant_id'),
                )
                ->where(
                    'product_id',
                    $product->id,
                )
                ->where('status', true)
                ->firstOrFail();
        }

        $item = $addItemToCart->execute(
            $request,
            $product,
            $variant,
            $request->integer('quantity'),
        );

        $cart = $this->resolveCart($request);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.',
            'cart_count' => $cart->totalQuantity(),
            'item_id' => $item->id,
        ]);
    }

    public function update(
        UpdateCartItemRequest $request,
        int $cartItem,
        UpdateCartItem $updateCartItem,
    ): JsonResponse {
        $item = $updateCartItem->execute(
            $request,
            $cartItem,
            $request->integer('quantity'),
        );

        $cart = $this->resolveCart($request);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully.',
            'cart_count' => $cart->totalQuantity(),
            'item_id' => $item->id,
            'quantity' => $item->quantity,
        ]);
    }

    public function destroy(
        Request $request,
        int $cartItem,
        RemoveCartItem $removeCartItem,
    ): JsonResponse {
        $removeCartItem->execute(
            $request,
            $cartItem,
        );

        $cart = $this->resolveCart($request);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cart->totalQuantity(),
        ]);
    }

    public function clear(
        Request $request,
        ClearCart $clearCart,
    ): JsonResponse {
        $clearCart->execute($request);

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
            'cart_count' => 0,
        ]);
    }

    private function resolveCart(Request $request): Cart
    {
        $user = $request->user();

        if ($user !== null) {
            return $user->cart()->firstOrCreate([
                'user_id' => $user->id,
            ]);
        }

        return Cart::query()->firstOrCreate([
            'session_id' => $request->session()->getId(),
        ]);
    }
}
