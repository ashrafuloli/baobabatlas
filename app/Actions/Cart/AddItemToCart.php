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
            |--------------------------------------------------------------------------
            | Lock Product
            |--------------------------------------------------------------------------
            */

            $product = Product::query()
                ->whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$product->isActive()) {
                throw ValidationException::withMessages([
                    'product_id' => 'This product is no longer available.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Product Type Validation
            |--------------------------------------------------------------------------
            */

            if ($product->isSimple() && $variant !== null) {
                throw ValidationException::withMessages([
                    'variant_id' => 'Simple products cannot have variants.',
                ]);
            }

            if ($product->isVariable() && $variant === null) {
                throw ValidationException::withMessages([
                    'variant_id' => 'Please select a product variant.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Resolve Variant
            |--------------------------------------------------------------------------
            */

            $lockedVariant = null;

            if ($product->isVariable()) {
                $lockedVariant = ProductVariant::query()
                    ->whereKey($variant?->id)
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
            |--------------------------------------------------------------------------
            | Simple Product Stock
            |--------------------------------------------------------------------------
            */

            if ($product->isSimple() && $product->stock < 1) {
                throw ValidationException::withMessages([
                    'quantity' => 'This product is currently out of stock.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Find Exact Cart Item
            |--------------------------------------------------------------------------
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
                $newQuantity += (int) $item->quantity;
            }

            /*
            |--------------------------------------------------------------------------
            | Stock Validation
            |--------------------------------------------------------------------------
            */

            $availableStock = $product->isSimple()
                ? (int) $product->stock
                : (int) $lockedVariant->stock;

            if ($newQuantity > $availableStock) {
                throw ValidationException::withMessages([
                    'quantity' => sprintf(
                        'Only %d item(s) are available in stock.',
                        $availableStock,
                    ),
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Create / Update Cart Item
            |--------------------------------------------------------------------------
            */

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
