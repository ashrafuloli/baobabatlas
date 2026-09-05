<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class RemoveCartItem
{
    public function execute(
        Request $request,
        int $cartItemId,
    ): void {
        DB::transaction(function () use (
            $request,
            $cartItemId,
        ): void {
            $cart = $this->resolveCart($request);

            /*
             * Lock the current cart before modifying its items.
             */
            $cart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Only delete an item belonging to the current cart.
             * This prevents removing another user's or another
             * guest session's cart item.
             */
            CartItem::query()
                ->where('cart_id', $cart->id)
                ->whereKey($cartItemId)
                ->lockForUpdate()
                ->delete();
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
