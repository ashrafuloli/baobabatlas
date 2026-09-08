<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Cart\AddItemToCart;
use App\Actions\Cart\CalculateCartCoupon;
use App\Actions\Cart\ClearCart;
use App\Actions\Cart\RemoveCartItem;
use App\Actions\Cart\UpdateCartItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

final class CartController extends Controller
{
    public function index(
        Request $request,
        CalculateCartCoupon $calculateCartCoupon,
    ): View {
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

        $appliedCoupon = null;
        $discount = 0.0;

        $sessionCoupon = $request->session()->get('cart_coupon');

        if ($sessionCoupon !== null) {
            $coupon = Coupon::query()
                ->whereKey($sessionCoupon['id'] ?? null)
                ->where('code', $sessionCoupon['code'] ?? '')
                ->where('is_active', true)
                ->first();

            if ($coupon !== null) {
                $now = now();

                $isStarted = $coupon->starts_at === null
                    || $now->greaterThanOrEqualTo($coupon->starts_at);

                $isNotExpired = $coupon->expires_at === null
                    || $now->lessThanOrEqualTo($coupon->expires_at);

                $hasUsageAvailable = $coupon->usage_limit === null
                    || $coupon->used_count < $coupon->usage_limit;

                if (
                    $isStarted
                    && $isNotExpired
                    && $hasUsageAvailable
                ) {
                    try {
                        $discount = $calculateCartCoupon->execute(
                            $cart,
                            $coupon,
                        );

                        $appliedCoupon = $coupon;
                    } catch (ValidationException) {
                        $request->session()->forget('cart_coupon');
                    }
                } else {
                    $request->session()->forget('cart_coupon');
                }
            } else {
                $request->session()->forget('cart_coupon');
            }
        }

        return view(
            'frontend.pages.shop.cart',
            compact(
                'cart',
                'appliedCoupon',
                'discount',
            ),
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

    public function applyCoupon(
        ApplyCouponRequest $request,
        CalculateCartCoupon $calculateCartCoupon,
    ): JsonResponse {
        $cart = $this->resolveCart($request);

        if (!$cart->items()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 422);
        }

        $coupon = Coupon::query()
            ->where('code', $request->string('code')->toString())
            ->where('is_active', true)
            ->first();

        if ($coupon === null) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive promo code.',
            ], 422);
        }

        $now = now();

        if (
            $coupon->starts_at !== null
            && $now->lt($coupon->starts_at)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This promo code is not active yet.',
            ], 422);
        }

        if (
            $coupon->expires_at !== null
            && $now->gt($coupon->expires_at)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This promo code has expired.',
            ], 422);
        }

        if (
            $coupon->usage_limit !== null
            && $coupon->used_count >= $coupon->usage_limit
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This promo code has reached its usage limit.',
            ], 422);
        }

        try {
            $discount = $calculateCartCoupon->execute(
                $cart,
                $coupon,
            );
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->errors()['code'][0]
                    ?? 'This promo code cannot be applied.',
            ], 422);
        }

        $request->session()->put('cart_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo code applied successfully.',
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
            ],
        ]);
    }

    public function removeCoupon(
        Request $request,
    ): JsonResponse {
        $request->session()->forget('cart_coupon');

        return response()->json([
            'success' => true,
            'message' => 'Promo code removed.',
        ]);
    }
}
