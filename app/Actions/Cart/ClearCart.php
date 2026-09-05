<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class ClearCart
{
    public function execute(Request $request): void
    {
        DB::transaction(function () use ($request): void {
            $cart = $this->resolveCart($request);

            /*
             * Lock the current cart before deleting its items.
             * This keeps cart mutations consistent with add, update,
             * and remove operations.
             */
            $cart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            $cart->items()->delete();
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
