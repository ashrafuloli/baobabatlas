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
     * Simple products use products.stock.
     * Variable products use product_variants.stock.
     *
     * Shipping is calculated once per cart line using the product's
     * customer-facing shipping_cost. Quantity does not multiply shipping.
     *
     * @return array{
     *     cart: Cart,
     *     items: Collection<int, CartItem>,
     *     default_address: ?UserAddress,
     *     currency: string,
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

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $currency = strtolower(
            (string) setting('currency', 'USD'),
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Cart & Calculate Subtotal / Shipping
        |--------------------------------------------------------------------------
        */

        $subtotal = 0.0;
        $shipping = 0.0;
        $totalQuantity = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            $variant = $item->variant;

            /*
            |--------------------------------------------------------------------------
            | Validate Product
            |--------------------------------------------------------------------------
            */

            if ($product === null || !$product->isActive()) {
                throw ValidationException::withMessages([
                    'cart' => sprintf(
                        'The product "%s" is no longer available.',
                        $product?->name ?? 'Unknown product',
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Quantity
            |--------------------------------------------------------------------------
            */

            $quantity = (int) $item->quantity;

            if ($quantity < 1) {
                throw ValidationException::withMessages([
                    'cart' => sprintf(
                        'Invalid quantity for "%s".',
                        $product->name,
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Product Type
            |--------------------------------------------------------------------------
            |
            | Simple:
            |     variant_id must be NULL
            |     stock comes from products.stock
            |
            | Variable:
            |     variant_id is required
            |     stock comes from product_variants.stock
            |
            */

            if ($product->isSimple()) {
                /*
                |--------------------------------------------------------------------------
                | Simple Product Must Not Have A Variant
                |--------------------------------------------------------------------------
                */

                if (
                    $item->variant_id !== null
                    || $variant !== null
                ) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'The cart item for "%s" contains an invalid variant.',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Simple Product Stock
                |--------------------------------------------------------------------------
                */

                $productStock = (int) $product->stock;

                if ($productStock < 1) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            '"%s" is currently out of stock.',
                            $product->name,
                        ),
                    ]);
                }

                if ($quantity > $productStock) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Only %d item(s) of "%s" are available.',
                            $productStock,
                            $product->name,
                        ),
                    ]);
                }
            } elseif ($product->isVariable()) {
                /*
                |--------------------------------------------------------------------------
                | Variable Product Must Have A Variant
                |--------------------------------------------------------------------------
                */

                if (
                    $item->variant_id === null
                    || $variant === null
                ) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Please select a variant for "%s".',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Variant Relationship & Status
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $variant->product_id !== (int) $product->id
                    || !$variant->isActive()
                ) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'The selected variant for "%s" is no longer available.',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Variant Stock
                |--------------------------------------------------------------------------
                */

                $variantStock = (int) $variant->stock;

                if ($variantStock < 1) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            '"%s" is currently out of stock.',
                            $product->name,
                        ),
                    ]);
                }

                if ($quantity > $variantStock) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Only %d item(s) of "%s" are available.',
                            $variantStock,
                            $product->name,
                        ),
                    ]);
                }
            } else {
                /*
                |--------------------------------------------------------------------------
                | Invalid Product Type
                |--------------------------------------------------------------------------
                */

                throw ValidationException::withMessages([
                    'cart' => sprintf(
                        'The product "%s" has an invalid product type.',
                        $product->name,
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Unit Price
            |--------------------------------------------------------------------------
            */

            $unitPrice = $product->isVariable()
                ? (float) $variant->price
                : (float) $product->price;

            if (
                !is_finite($unitPrice)
                || $unitPrice < 0
            ) {
                throw ValidationException::withMessages([
                    'cart' => sprintf(
                        'Invalid price for "%s".',
                        $product->name,
                    ),
                ]);
            }

            $itemTotal = round(
                $unitPrice * $quantity,
                2,
            );

            /*
            |--------------------------------------------------------------------------
            | Product Shipping Cost
            |--------------------------------------------------------------------------
            |
            | Shipping is charged once per cart line.
            |
            | Example:
            |
            | Product A
            | Quantity: 5
            | Shipping: $10
            |
            | Shipping remains $10, NOT $50.
            |
            */

            $shippingCost = max(
                0.0,
                (float) ($product->shipping_cost ?? 0),
            );

            $shippingCost = round(
                $shippingCost,
                2,
            );

            /*
            |--------------------------------------------------------------------------
            | Checkout Attributes
            |--------------------------------------------------------------------------
            */

            $item->setAttribute(
                'checkout_unit_price',
                $unitPrice,
            );

            $item->setAttribute(
                'checkout_total',
                $itemTotal,
            );

            $item->setAttribute(
                'checkout_shipping_cost',
                $shippingCost,
            );

            /*
            |--------------------------------------------------------------------------
            | Accumulate Totals
            |--------------------------------------------------------------------------
            */

            $subtotal += $itemTotal;

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Shipping is per cart line, not per quantity.
            |--------------------------------------------------------------------------
            */

            $shipping += $shippingCost;

            $totalQuantity += $quantity;
        }

        $subtotal = round(
            $subtotal,
            2,
        );

        $shipping = round(
            $shipping,
            2,
        );

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
        | Coupon / Discount
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
                            max(
                                0.0,
                                (float) $discount,
                            ),
                            $subtotal,
                        );
                    } catch (ValidationException) {
                        session()->forget('cart_coupon');

                        $discount = 0.0;
                    }
                }
            }
        }

        $discount = round(
            $discount,
            2,
        );

        /*
        |--------------------------------------------------------------------------
        | Tax
        |--------------------------------------------------------------------------
        */

        $tax = 0.0;

        /*
        |--------------------------------------------------------------------------
        | Final Total
        |--------------------------------------------------------------------------
        */

        $total = round(
            max(
                0.0,
                $subtotal
                + $shipping
                + $tax
                - $discount,
            ),
            2,
        );

        /*
        |--------------------------------------------------------------------------
        | Return Checkout Data
        |--------------------------------------------------------------------------
        */

        return [
            'cart' => $cart,
            'items' => $cart->items,
            'default_address' => $defaultAddress,
            'currency' => $currency,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'item_count' => $cart->items->count(),
            'quantity' => $totalQuantity,
        ];
    }
}
