<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class AddItemToCart
{
    public function execute(
        Request $request,
        Product $product,
        ?ProductVariant $variant,
        int $quantity,
    ): CartItem {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'The quantity must be at least 1.',
            ]);
        }

        return DB::transaction(function () use (
            $request,
            $product,
            $variant,
            $quantity,
        ): CartItem {
            $cart = $this->resolveCart($request);

            $cart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Re-check the product inside the transaction.
             */
            if (!$product->isActive()) {
                throw ValidationException::withMessages([
                    'product_id' => 'This product is no longer available.',
                ]);
            }

            $lockedVariant = null;

            if ($variant !== null) {
                /*
                 * Lock the variant row so concurrent requests cannot
                 * exceed the available stock while modifying the cart.
                 */
                $lockedVariant = ProductVariant::query()
                    ->whereKey($variant->id)
                    ->where('product_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if (
                    $lockedVariant === null
                    || !$lockedVariant->isActive()
                ) {
                    throw ValidationException::withMessages([
                        'variant_id' => 'The selected product variant is invalid.',
                    ]);
                }

                if ($lockedVariant->stock < 1) {
                    throw ValidationException::withMessages([
                        'quantity' => 'This product variant is currently out of stock.',
                    ]);
                }
            }

            /*
             * Find the exact cart item:
             *
             * Product + Variant
             *
             * or
             *
             * Product + NULL variant
             */
            $item = CartItem::query()
                ->where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->when(
                    $lockedVariant !== null,
                    function ($query) use ($lockedVariant): void {
                        $query->where(
                            'variant_id',
                            $lockedVariant->id,
                        );
                    },
                    function ($query): void {
                        $query->whereNull('variant_id');
                    },
                )
                ->lockForUpdate()
                ->first();

            $newQuantity = $quantity;

            if ($item !== null) {
                $newQuantity += $item->quantity;
            }

            /*
             * Only variants have stock in the current schema.
             *
             * Non-variant products intentionally do not receive
             * artificial stock validation here.
             */
            if (
                $lockedVariant !== null
                && $newQuantity > $lockedVariant->stock
            ) {
                throw ValidationException::withMessages([
                    'quantity' => sprintf(
                        'Only %d item(s) are available in stock.',
                        $lockedVariant->stock,
                    ),
                ]);
            }

            if ($item === null) {
                return $cart->items()->create([
                    'product_id' => $product->id,
                    'variant_id' => $lockedVariant?->id,
                    'quantity' => $quantity,
                ]);
            }

            $item->update([
                'quantity' => $newQuantity,
            ]);

            return $item->refresh();
        });
    }

    private function resolveCart(Request $request): Cart
    {
        $user = $request->user();

        if ($user !== null) {
            return Cart::query()->firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'session_id' => null,
                ],
            );
        }

        return Cart::query()->firstOrCreate(
            [
                'session_id' => $request->session()->getId(),
            ],
            [
                'user_id' => null,
            ],
        );
    }
}
