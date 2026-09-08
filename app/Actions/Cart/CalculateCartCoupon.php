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

        $eligibleSubtotal = 0.0;

        $hasProductRestrictions = $coupon
            ->products()
            ->exists();

        foreach ($cart->items as $item) {
            $product = $item->product;

            if ($product === null || !$product->isActive()) {
                continue;
            }

            if (
                $hasProductRestrictions
                && !$coupon->products()
                    ->whereKey($product->id)
                    ->exists()
            ) {
                continue;
            }

            $unitPrice = $item->variant
                ? (float) $item->variant->price
                : (float) $product->price;

            $eligibleSubtotal +=
                $unitPrice * $item->quantity;
        }

        if (
            $eligibleSubtotal <
            (float) $coupon->minimum_amount
        ) {
            throw ValidationException::withMessages([
                'code' => sprintf(
                    'Minimum order amount for this promo code is $%s.',
                    number_format(
                        (float) $coupon->minimum_amount,
                        2
                    )
                ),
            ]);
        }

        if ($coupon->discount_type === 'percentage') {
            $discount =
                $eligibleSubtotal
                * ((float) $coupon->discount_value / 100);

            /*
             * 0 means no maximum discount limit.
             */
            if (
                $coupon->maximum_discount !== null
                && (float) $coupon->maximum_discount > 0
            ) {
                $discount = min(
                    $discount,
                    (float) $coupon->maximum_discount
                );
            }
        } else {
            $discount = min(
                (float) $coupon->discount_value,
                $eligibleSubtotal
            );
        }

        return round(
            max(0, $discount),
            2
        );
    }
}
