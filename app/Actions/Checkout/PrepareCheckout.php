<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Actions\Cart\CalculateCartCoupon;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\UserAddress;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

final class PrepareCheckout
{
    /**
     * Prepare and validate the authenticated user's cart for checkout.
     *
     * @return array{
     *     cart: Cart,
     *     items: Collection<int, CartItem>,
     *     default_address: ?UserAddress,
     *     subtotal: float,
     *     discount: float,
     *     shipping: float,
     *     tax: float,
     *     total: float,
     *     item_count: int,
     *     quantity: int
     * }
     */
    public function __construct(
        private readonly CalculateCartCoupon $calculateCartCoupon,
    ) {
    }

    public function execute(Cart $cart): array
    {
        $cart->load([
            'items.product.brand',
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

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'Your cart is empty.',
            ]);
        }

        $subtotal = 0.0;
        $totalQuantity = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            $variant = $item->variant;

            if ($product === null || !$product->isActive()) {
                throw ValidationException::withMessages([
                    'cart' => sprintf(
                        'The product "%s" is no longer available.',
                        $product?->name ?? 'Unknown product',
                    ),
                ]);
            }

            if ($variant !== null) {
                if (
                    $variant->product_id !== $product->id
                    || !$variant->isActive()
                ) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'The selected variant for "%s" is no longer available.',
                            $product->name,
                        ),
                    ]);
                }

                if ($variant->stock < 1) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            '"%s" is currently out of stock.',
                            $product->name,
                        ),
                    ]);
                }

                if ($item->quantity > $variant->stock) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Only %d item(s) of "%s" are available.',
                            $variant->stock,
                            $product->name,
                        ),
                    ]);
                }
            }

            $unitPrice = $variant !== null
                ? (float) $variant->price
                : (float) $product->price;

            $itemTotal = $unitPrice * $item->quantity;

            $item->setAttribute(
                'checkout_unit_price',
                $unitPrice,
            );

            $item->setAttribute(
                'checkout_total',
                $itemTotal,
            );

            $subtotal += $itemTotal;
            $totalQuantity += $item->quantity;
        }

        /*
        |--------------------------------------------------------------------------
        | Default Shipping Address
        |--------------------------------------------------------------------------
        */

        $defaultAddress = $cart->user_id !== null
            ? UserAddress::query()
                ->where('user_id', $cart->user_id)
                ->where('is_default', true)
                ->latest('id')
                ->first()
            : null;

        /*
        |--------------------------------------------------------------------------
        | Coupon
        |--------------------------------------------------------------------------
        */

        $discount = 0.0;

        $sessionCoupon = session('cart_coupon');

        if (
            is_array($sessionCoupon)
            && isset(
                $sessionCoupon['id'],
                $sessionCoupon['code'],
            )
        ) {
            $coupon = Coupon::query()
                ->whereKey($sessionCoupon['id'])
                ->where(
                    'code',
                    $sessionCoupon['code'],
                )
                ->where('is_active', true)
                ->first();

            if ($coupon === null) {
                session()->forget('cart_coupon');
            } else {
                $now = now();

                $isStarted = $coupon->starts_at === null
                    || $now->greaterThanOrEqualTo(
                        $coupon->starts_at,
                    );

                $isNotExpired = $coupon->expires_at === null
                    || $now->lessThanOrEqualTo(
                        $coupon->expires_at,
                    );

                $hasUsageAvailable =
                    $coupon->usage_limit === null
                    || $coupon->used_count < $coupon->usage_limit;

                if (
                    !$isStarted
                    || !$isNotExpired
                    || !$hasUsageAvailable
                ) {
                    session()->forget('cart_coupon');
                } else {
                    try {
                        /*
                        |--------------------------------------------------------------------------
                        | Maximum Discount
                        |--------------------------------------------------------------------------
                        |
                        | A maximum discount of 0 means no maximum
                        | discount limit.
                        |
                        */

                        if (
                            $coupon->maximum_discount !== null
                            && (float) $coupon->maximum_discount <= 0
                        ) {
                            $coupon->setAttribute(
                                'maximum_discount',
                                null,
                            );
                        }

                        $discount = $this->calculateCartCoupon->execute(
                            $cart,
                            $coupon,
                        );

                        $discount = min(
                            max(0.0, (float) $discount),
                            $subtotal,
                        );
                    } catch (ValidationException) {
                        session()->forget('cart_coupon');

                        $discount = 0.0;
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Shipping & Tax
        |--------------------------------------------------------------------------
        */

        $shipping = 0.0;
        $tax = 0.0;

        /*
        |--------------------------------------------------------------------------
        | Final Total
        |--------------------------------------------------------------------------
        */

        $total = max(
            0.0,
            $subtotal + $shipping + $tax - $discount,
        );

        return [
            'cart' => $cart,
            'items' => $cart->items,
            'default_address' => $defaultAddress,
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'shipping' => round($shipping, 2),
            'tax' => round($tax, 2),
            'total' => round($total, 2),
            'item_count' => $cart->items->count(),
            'quantity' => $totalQuantity,
        ];
    }
}
