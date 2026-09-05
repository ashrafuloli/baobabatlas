<?php

declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Models\Cart;
use App\Models\CartItem;
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

        $defaultAddress = $cart->user_id !== null
            ? UserAddress::query()
                ->where('user_id', $cart->user_id)
                ->where('is_default', true)
                ->latest('id')
                ->first()
            : null;

        $discount = 0.0;
        $shipping = 0.0;
        $tax = 0.0;

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
