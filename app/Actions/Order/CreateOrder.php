<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\Cart;
use App\Models\Order;
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

            foreach ($cart->items as $cartItem) {
                $product = $cartItem->product;

                if ($product === null || !$product->isActive()) {
                    throw ValidationException::withMessages([
                        'cart' => 'A product in your cart is no longer available.',
                    ]);
                }

                $variant = $cartItem->variant;

                /*
                |--------------------------------------------------------------------------
                | Variant Validation
                |--------------------------------------------------------------------------
                */

                if ($variant !== null) {
                    if (
                        $variant->product_id !== $product->id
                        || !$variant->isActive()
                    ) {
                        throw ValidationException::withMessages([
                            'cart' => 'A selected product variant is no longer available.',
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Lock Variant
                    |--------------------------------------------------------------------------
                    |
                    | Re-read the variant with a row lock so stock cannot change
                    | underneath this order creation transaction.
                    |
                    */

                    $variant = $variant->newQuery()
                        ->whereKey($variant->id)
                        ->lockForUpdate()
                        ->first();

                    if ($variant === null || !$variant->isActive()) {
                        throw ValidationException::withMessages([
                            'cart' => 'A selected product variant is no longer available.',
                        ]);
                    }

                    if ($variant->product_id !== $product->id) {
                        throw ValidationException::withMessages([
                            'cart' => 'The selected product variant is invalid.',
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

                    if ($cartItem->quantity > $variant->stock) {
                        throw ValidationException::withMessages([
                            'cart' => sprintf(
                                'Only %d item(s) are available for "%s".',
                                $variant->stock,
                                $product->name,
                            ),
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Validate Quantity
                |--------------------------------------------------------------------------
                */

                $quantity = (int) $cartItem->quantity;

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
                | Determine Current Price
                |--------------------------------------------------------------------------
                */

                $unitPrice = (float) (
                    $variant?->price
                    ?? $product->price
                );

                if (!is_finite($unitPrice) || $unitPrice < 0) {
                    throw ValidationException::withMessages([
                        'cart' => sprintf(
                            'Invalid price for "%s".',
                            $product->name,
                        ),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Convert To Cents
                |--------------------------------------------------------------------------
                |
                | Money calculations are kept in integer cents to avoid
                | floating-point rounding problems.
                |
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

                $lineTotalCents =
                    $unitPriceCents * $quantity;

                $subtotalCents += $lineTotalCents;

                $items->push([
                    'cart_item' => $cartItem,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'unit_price_cents' => $unitPriceCents,
                    'line_total_cents' => $lineTotalCents,
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
            | Checkout Totals
            |--------------------------------------------------------------------------
            |
            | These values come from PrepareCheckout, but we normalize them
            | again here because this is the final server-side order creation
            | boundary.
            |
            */

            $discountCents = $this->toCents(
                $totals['discount'] ?? 0,
            );

            $shippingCents = $this->toCents(
                $totals['shipping'] ?? 0,
            );

            $taxCents = $this->toCents(
                $totals['tax'] ?? 0,
            );

            if (
                $discountCents < 0
                || $shippingCents < 0
                || $taxCents < 0
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
                + $shippingCents
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
                $shippingCents,
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
            | Discount is allocated in cents rather than floating-point values.
            | The final item receives the remainder so the exact discounted
            | merchandise total always equals:
            |
            | subtotal - discount
            |
            */

            $allocatedDiscountCents = 0;
            $itemCount = $items->count();

            foreach ($items as $index => $item) {
                $lineTotalCents =
                    (int) $item['line_total_cents'];

                /*
                |--------------------------------------------------------------------------
                | Proportional Discount Allocation
                |--------------------------------------------------------------------------
                */

                if (
                    $discountCents <= 0
                    || $subtotalCents <= 0
                ) {
                    $itemDiscountCents = 0;
                } elseif ($index === $itemCount - 1) {
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
                | Store Exact Unit Price
                |--------------------------------------------------------------------------
                |
                | Because order_items.unit_price has 2 decimal places, an exact
                | per-unit representation may not always be possible.
                |
                | CreateStripeCheckoutSession therefore uses line_total as the
                | authoritative amount and splits Stripe quantities into exact
                | cent values when required.
                |
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
                | Product Image
                |--------------------------------------------------------------------------
                */

                $image = $item['variant']?->image;

                if ($image === null) {
                    $image = $item['product']
                        ->images
                        ->whereNull('variant_id')
                        ->sortByDesc('is_primary')
                        ->first()?->image;
                }

                /*
                |--------------------------------------------------------------------------
                | Create Order Item
                |--------------------------------------------------------------------------
                */

                $order->items()->create([
                    'product_id' => $item['product']->id,

                    'variant_id' => $item['variant']?->id,

                    'product_name' => $item['product']->name,

                    'sku' => $item['variant']?->sku,

                    'image' => $image,

                    'quantity' => $quantity,

                    'unit_price' => $discountedUnitPrice,

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
