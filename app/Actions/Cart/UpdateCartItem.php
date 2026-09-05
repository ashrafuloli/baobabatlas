<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class UpdateCartItem
{
    public function execute(
        Request $request,
        int $cartItemId,
        int $quantity,
    ): CartItem {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'The quantity must be at least 1.',
            ]);
        }

        return DB::transaction(function () use (
            $request,
            $cartItemId,
            $quantity,
        ): CartItem {
            $cart = $this->resolveCart($request);

            /*
             * Lock the cart row before modifying one of its items.
             */
            $cart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Only retrieve an item that belongs to the resolved cart.
             * This prevents users from modifying another user's or
             * another guest session's cart item.
             */
            $item = CartItem::query()
                ->where('cart_id', $cart->id)
                ->whereKey($cartItemId)
                ->with('product')
                ->lockForUpdate()
                ->first();

            if ($item === null) {
                throw new ModelNotFoundException();
            }

            $product = $item->product;

            if ($product === null || !$product->isActive()) {
                throw ValidationException::withMessages([
                    'quantity' => 'This product is no longer available.',
                ]);
            }

            $variant = null;

            if ($item->variant_id !== null) {
                /*
                 * Lock the variant row so stock cannot change between
                 * validation and the cart update.
                 */
                $variant = ProductVariant::query()
                    ->whereKey($item->variant_id)
                    ->where('product_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if (
                    $variant === null
                    || !$variant->isActive()
                ) {
                    throw ValidationException::withMessages([
                        'quantity' => 'This product variant is no longer available.',
                    ]);
                }

                if ($variant->stock < 1) {
                    throw ValidationException::withMessages([
                        'quantity' => 'This product variant is currently out of stock.',
                    ]);
                }

                if ($quantity > $variant->stock) {
                    throw ValidationException::withMessages([
                        'quantity' => sprintf(
                            'Only %d item(s) are available in stock.',
                            $variant->stock,
                        ),
                    ]);
                }
            }

            /*
             * Non-variant products do not have a stock column in the
             * current schema, so no artificial stock validation is applied.
             */
            $item->update([
                'quantity' => $quantity,
            ]);

            return $item->refresh();
        });
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
