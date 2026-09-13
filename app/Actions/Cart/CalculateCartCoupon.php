<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Validation\ValidationException;

final class CalculateCartCoupon
{
    public function execute(
        Cart $cart,
        Coupon $coupon,
    ): float {
        $cart->loadMissing([
            'items.product',
            'items.variant',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Determine Product Restrictions
        |--------------------------------------------------------------------------
        */

        $restrictedProductIds = $coupon
            ->products()
            ->pluck('products.id');

        $hasProductRestrictions = $restrictedProductIds->isNotEmpty();

        /*
        |--------------------------------------------------------------------------
        | Calculate Eligible Merchandise Subtotal
        |--------------------------------------------------------------------------
        |
        | Coupon applies only to product merchandise.
        |
        | Shipping cost is intentionally excluded.
        |
        */

        $eligibleSubtotalCents = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;

            if ($product === null || !$product->isActive()) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Product Restriction
            |--------------------------------------------------------------------------
            */

            if (
                $hasProductRestrictions
                && !$restrictedProductIds->contains(
                    (int) $product->id,
                )
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Quantity
            |--------------------------------------------------------------------------
            */

            $quantity = (int) $item->quantity;

            if ($quantity < 1) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Unit Price
            |--------------------------------------------------------------------------
            */

            $unitPrice = $item->variant !== null
                ? (float) $item->variant->price
                : (float) $product->price;

            $unitPriceCents = (int) round(
                $unitPrice * 100,
            );

            if ($unitPriceCents < 0) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Eligible Merchandise Amount
            |--------------------------------------------------------------------------
            */

            $eligibleSubtotalCents +=
                $unitPriceCents * $quantity;
        }

        $eligibleSubtotal = round(
            $eligibleSubtotalCents / 100,
            2,
        );

        /*
        |--------------------------------------------------------------------------
        | Minimum Order Amount
        |--------------------------------------------------------------------------
        |
        | Minimum amount is checked against eligible merchandise only.
        | Shipping is NOT included.
        |
        */

        $minimumAmount = max(
            0.0,
            (float) $coupon->minimum_amount,
        );

        if ($eligibleSubtotal < $minimumAmount) {
            throw ValidationException::withMessages([
                'code' => sprintf(
                    'Minimum order amount for this promo code is $%s.',
                    number_format(
                        $minimumAmount,
                        2,
                    ),
                ),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Discount
        |--------------------------------------------------------------------------
        */

        if ($coupon->discount_type === 'percentage') {
            $discount = $eligibleSubtotal
                * ((float) $coupon->discount_value / 100);

            /*
            |--------------------------------------------------------------------------
            | Maximum Discount
            |--------------------------------------------------------------------------
            |
            | A null or zero maximum means unlimited.
            |
            */

            if (
                $coupon->maximum_discount !== null
                && (float) $coupon->maximum_discount > 0
            ) {
                $discount = min(
                    $discount,
                    (float) $coupon->maximum_discount,
                );
            }
        } else {
            /*
            |--------------------------------------------------------------------------
            | Fixed Discount
            |--------------------------------------------------------------------------
            */

            $discount = min(
                max(
                    0.0,
                    (float) $coupon->discount_value,
                ),
                $eligibleSubtotal,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Final Discount
        |--------------------------------------------------------------------------
        */

        return round(
            max(
                0.0,
                min(
                    $discount,
                    $eligibleSubtotal,
                ),
            ),
            2,
        );
    }
}
