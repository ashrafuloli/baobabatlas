<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class CreateOrder
{
    public function execute(
        Cart $cart,
        array $checkoutData,
        array $totals,
    ): Order {
        return DB::transaction(function () use (
            $cart,
            $checkoutData,
            $totals,
        ): Order {
            /*
            |--------------------------------------------------------------------------
            | Lock Cart
            |--------------------------------------------------------------------------
            */

            $cart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->with([
                    'items' => function ($query): void {
                        $query->orderBy('id');
                    },
                    'items.product',
                    'items.product.images' => function ($query): void {
                        $query
                            ->whereNull('variant_id')
                            ->orderByDesc('is_primary')
                            ->orderBy('sort_order');
                    },
                    'items.variant',
                ])
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate & Prepare Cart Items
            |--------------------------------------------------------------------------
            */

            $items = new Collection();

            $subtotalCents = 0;

            $shippingCents = 0;

            foreach ($cart->items as $cartItem) {
                /*
                |--------------------------------------------------------------------------
                | Validate Quantity
                |--------------------------------------------------------------------------
                */

                $quantity = (int) $cartItem->quantity;

                if ($quantity < 1) {
                    throw ValidationException::withMessages([
                        'cart' => 'Invalid cart quantity.',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Resolve & Lock Product
                |--------------------------------------------------------------------------
                |
                | Simple products store their stock directly on products.
                | We therefore lock the product row during checkout validation.
                |
                */

                $product = Product::query()
                    ->whereKey($cartItem->product_id)
                    ->lockForUpdate()
                    ->first();

                if (
                    $product === null
                    || !$product->isActive()
                ) {
                    throw ValidationException::withMessages([
                        'cart' => 'A product in your cart is no longer available.',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Resolve Cart Variant
                |--------------------------------------------------------------------------
                */

                $variant = $cartItem->variant;

                /*
                |--------------------------------------------------------------------------
                | SIMPLE PRODUCT
                |--------------------------------------------------------------------------
                |
                | Simple product:
                |
                | products.stock = actual stock
                | variant_id = NULL
                |
                */

                if ($product->isSimple()) {
                    /*
                    |--------------------------------------------------------------------------
                    | Simple Product Must Not Have Variant
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $cartItem->variant_id !== null
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
                                'Only %d item(s) are available for "%s".',
                                $productStock,
                                $product->name,
                            ),
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | VARIABLE PRODUCT
                |--------------------------------------------------------------------------
                |
                | Variable product:
                |
                | products.stock = 0 / not used
                | product_variants.stock = actual stock
                | variant_id = required
                |
                */

                elseif ($product->isVariable()) {
                    /*
                    |--------------------------------------------------------------------------
                    | Variable Product Requires Variant
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $cartItem->variant_id === null
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
                    | Lock Variant
                    |--------------------------------------------------------------------------
                    */

                    $variant = ProductVariant::query()
                        ->whereKey($variant->id)
                        ->where('product_id', $product->id)
                        ->lockForUpdate()
                        ->first();

                    if (
                        $variant === null
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
                                'Only %d item(s) are available for "%s".',
                                $variantStock,
                                $product->name,
                            ),
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Invalid Product Type
                |--------------------------------------------------------------------------
                */

                else {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'The product "%s" has an invalid product type.',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Determine Current Unit Price
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

                /*
                |--------------------------------------------------------------------------
                | Convert Unit Price To Cents
                |--------------------------------------------------------------------------
                */

                $unitPriceCents = (int) round(
                    $unitPrice * 100,
                );

                if ($unitPriceCents < 0) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Invalid price for "%s".',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Calculate Product Line Total
                |--------------------------------------------------------------------------
                */

                $lineTotalCents =
                    $unitPriceCents * $quantity;

                $subtotalCents += $lineTotalCents;

                /*
                |--------------------------------------------------------------------------
                | Product Shipping Cost
                |--------------------------------------------------------------------------
                |
                | Shipping is charged once per cart line.
                |
                */

                $itemShippingCost = (float) (
                    $product->shipping_cost ?? 0
                );

                if (
                    !is_finite($itemShippingCost)
                    || $itemShippingCost < 0
                ) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Invalid shipping cost for "%s".',
                            $product->name,
                        ),
                    ]);
                }

                $itemShippingCents = (int) round(
                    $itemShippingCost * 100,
                );

                $shippingCents += $itemShippingCents;

                /*
                |--------------------------------------------------------------------------
                | Prepare Order Item Data
                |--------------------------------------------------------------------------
                */

                $items->push([
                    'cart_item' => $cartItem,

                    'product' => $product,

                    'variant' => $variant,

                    'quantity' => $quantity,

                    'unit_price_cents' => $unitPriceCents,

                    'line_total_cents' => $lineTotalCents,

                    'shipping_cost_cents' => $itemShippingCents,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Subtotal
            |--------------------------------------------------------------------------
            */

            if ($subtotalCents <= 0) {
                throw ValidationException::withMessages([
                    'cart' => 'The cart does not contain any payable items.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Shipping
            |--------------------------------------------------------------------------
            |
            | Shipping is calculated directly from current products.
            | We do not trust client-provided shipping.
            |
            */

            $calculatedShippingCents = $shippingCents;

            /*
            |--------------------------------------------------------------------------
            | Checkout Discount & Tax
            |--------------------------------------------------------------------------
            */

            $discountCents = $this->toCents(
                $totals['discount'] ?? 0,
            );

            $taxCents = $this->toCents(
                $totals['tax'] ?? 0,
            );

            if (
                $discountCents < 0
                || $taxCents < 0
                || $calculatedShippingCents < 0
            ) {
                throw ValidationException::withMessages([
                    'cart' => 'Invalid checkout totals.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent Excessive Discount
            |--------------------------------------------------------------------------
            */

            if ($discountCents > $subtotalCents) {
                $discountCents = $subtotalCents;
            }

            /*
            |--------------------------------------------------------------------------
            | Calculate Final Total
            |--------------------------------------------------------------------------
            */

            $totalCents = max(
                0,
                $subtotalCents
                + $calculatedShippingCents
                + $taxCents
                - $discountCents,
            );

            if ($totalCents <= 0) {
                throw ValidationException::withMessages([
                    'cart' => 'There is no payable amount for this order.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $currency = strtolower(
                trim(
                    (string) (
                        $totals['currency']
                        ?? config('app.currency', 'usd')
                    ),
                ),
            );

            if (
                $currency === ''
                || strlen($currency) !== 3
            ) {
                throw ValidationException::withMessages([
                    'cart' => 'Invalid checkout currency.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Convert Totals Back To Decimal Values
            |--------------------------------------------------------------------------
            */

            $subtotal = $this->fromCents(
                $subtotalCents,
            );

            $discount = $this->fromCents(
                $discountCents,
            );

            $shipping = $this->fromCents(
                $calculatedShippingCents,
            );

            $tax = $this->fromCents(
                $taxCents,
            );

            $total = $this->fromCents(
                $totalCents,
            );

            /*
            |--------------------------------------------------------------------------
            | Create Order
            |--------------------------------------------------------------------------
            */

            $order = Order::query()->create([
                'user_id' => $cart->user_id,

                'order_number' => $this->generateOrderNumber(),

                'status' => Order::STATUS_PENDING,

                'payment_status' => Order::PAYMENT_STATUS_PENDING,

                'payment_gateway' => null,

                'stripe_checkout_session_id' => null,

                'stripe_payment_intent_id' => null,

                'currency' => $currency,

                'subtotal' => $subtotal,

                'discount' => $discount,

                'shipping' => $shipping,

                'tax' => $tax,

                'total' => $total,

                'first_name' => trim(
                    (string) $checkoutData['first_name'],
                ),

                'last_name' => trim(
                    (string) $checkoutData['last_name'],
                ),

                'email' => trim(
                    (string) $checkoutData['email'],
                ),

                'phone' => trim(
                    (string) $checkoutData['phone'],
                ),

                'country' => strtoupper(
                    trim(
                        (string) $checkoutData['country'],
                    ),
                ),

                'address' => trim(
                    (string) $checkoutData['address'],
                ),

                'apartment' => isset($checkoutData['apartment'])
                    ? trim(
                        (string) $checkoutData['apartment'],
                    )
                    : null,

                'city' => trim(
                    (string) $checkoutData['city'],
                ),

                'state' => isset($checkoutData['state'])
                    ? trim(
                        (string) $checkoutData['state'],
                    )
                    : null,

                'postal_code' => trim(
                    (string) $checkoutData['postal_code'],
                ),

                'notes' => isset($checkoutData['notes'])
                    ? trim(
                        (string) $checkoutData['notes'],
                    )
                    : null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Order Items
            |--------------------------------------------------------------------------
            |
            | Discount is allocated proportionally in cents.
            |
            | Shipping remains separate from line_total and is stored as
            | the product shipping snapshot.
            |
            */

            $allocatedDiscountCents = 0;

            $itemCount = $items->count();

            foreach ($items as $index => $item) {
                $lineTotalCents =
                    (int) $item['line_total_cents'];

                /*
                |--------------------------------------------------------------------------
                | Allocate Discount
                |--------------------------------------------------------------------------
                */

                if (
                    $discountCents <= 0
                    || $subtotalCents <= 0
                ) {
                    $itemDiscountCents = 0;
                } elseif ($index === $itemCount - 1) {
                    /*
                    |--------------------------------------------------------------------------
                    | Last Item Gets Remaining Discount
                    |--------------------------------------------------------------------------
                    */

                    $itemDiscountCents =
                        $discountCents
                        - $allocatedDiscountCents;
                } else {
                    $itemDiscountCents = (int) round(
                        (
                            $lineTotalCents
                            / $subtotalCents
                        ) * $discountCents,
                    );
                }

                $itemDiscountCents = min(
                    max(0, $itemDiscountCents),
                    $lineTotalCents,
                );

                $allocatedDiscountCents +=
                    $itemDiscountCents;

                /*
                |--------------------------------------------------------------------------
                | Final Discounted Line Total
                |--------------------------------------------------------------------------
                */

                $discountedLineTotalCents =
                    $lineTotalCents
                    - $itemDiscountCents;

                /*
                |--------------------------------------------------------------------------
                | Discounted Unit Price
                |--------------------------------------------------------------------------
                */

                $quantity = (int) $item['quantity'];

                $discountedUnitPriceCents = $quantity > 0
                    ? intdiv(
                        $discountedLineTotalCents,
                        $quantity,
                    )
                    : 0;

                $discountedUnitPrice =
                    $this->fromCents(
                        $discountedUnitPriceCents,
                    );

                $discountedLineTotal =
                    $this->fromCents(
                        $discountedLineTotalCents,
                    );

                /*
                |--------------------------------------------------------------------------
                | Product Image Snapshot
                |--------------------------------------------------------------------------
                |
                | Variable product:
                |     1. Variant image
                |     2. Product thumbnail
                |     3. Primary gallery image
                |
                | Simple product:
                |     1. Product thumbnail
                |     2. Primary gallery image
                |
                | The final image is stored in order_items.image so the
                | historical order does not depend on the current product image.
                |
                */

                $image = $item['variant']?->image
                    ?? $item['product']->thumbnail
                    ?? $item['product']
                        ->images
                        ->whereNull('variant_id')
                        ->sortByDesc('is_primary')
                        ->sortBy('sort_order')
                        ->first()?->image;

                /*
                |--------------------------------------------------------------------------
                | Shipping Cost Snapshot
                |--------------------------------------------------------------------------
                */

                $shippingCost = $this->fromCents(
                    (int) $item['shipping_cost_cents'],
                );

                /*
                |--------------------------------------------------------------------------
                | SKU Snapshot
                |--------------------------------------------------------------------------
                |
                | Simple product:
                |     product.sku
                |
                | Variable product:
                |     variant.sku
                |
                */

                $sku = $item['variant']?->sku
                    ?? $item['product']->sku;

                /*
                |--------------------------------------------------------------------------
                | Create Order Item
                |--------------------------------------------------------------------------
                */

                $order->items()->create([
                    'product_id' => $item['product']->id,

                    'variant_id' => $item['variant']?->id,

                    'product_name' => $item['product']->name,

                    'sku' => $sku,

                    'image' => $image,

                    'quantity' => $quantity,

                    'unit_price' => $discountedUnitPrice,

                    'shipping_cost' => $shippingCost,

                    'line_total' => $discountedLineTotal,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Final Discount Allocation Check
            |--------------------------------------------------------------------------
            */

            if (
                $allocatedDiscountCents
                !== $discountCents
            ) {
                throw ValidationException::withMessages([
                    'cart' => 'Unable to calculate the order discount correctly.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Final Shipping Validation
            |--------------------------------------------------------------------------
            */

            $orderItemShippingCents = $items->sum(
                static fn (array $item): int =>
                (int) $item['shipping_cost_cents'],
            );

            if (
                $orderItemShippingCents
                !== $calculatedShippingCents
            ) {
                throw ValidationException::withMessages([
                    'cart' => 'Unable to calculate the order shipping correctly.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Return Order
            |--------------------------------------------------------------------------
            */

            return $order->load('items');
        });
    }

    /**
     * Convert a monetary value to integer cents.
     */
    private function toCents(mixed $value): int
    {
        if (
            !is_numeric($value)
            || !is_finite((float) $value)
        ) {
            throw ValidationException::withMessages([
                'cart' => 'Invalid checkout amount.',
            ]);
        }

        return (int) round(
            (float) $value * 100,
        );
    }

    /**
     * Convert integer cents to a decimal monetary value.
     */
    private function fromCents(int $cents): float
    {
        return round(
            $cents / 100,
            2,
        );
    }

    /**
     * Generate a unique order number.
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(
                    Str::random(10),
                );
        } while (
            Order::query()
                ->where('order_number', $orderNumber)
                ->exists()
        );

        return $orderNumber;
    }
}
