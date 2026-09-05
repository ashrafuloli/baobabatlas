<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class MergeGuestCart
{
    public function execute(
        User $user,
        string $guestSessionId,
    ): void {
        DB::transaction(function () use (
            $user,
            $guestSessionId,
        ): void {
            $guestCart = Cart::query()
                ->where('session_id', $guestSessionId)
                ->lockForUpdate()
                ->first();

            if ($guestCart === null) {
                return;
            }

            $guestItems = CartItem::query()
                ->where('cart_id', $guestCart->id)
                ->with([
                    'product',
                    'variant',
                ])
                ->lockForUpdate()
                ->get();

            if ($guestItems->isEmpty()) {
                $guestCart->delete();

                return;
            }

            $userCart = Cart::query()
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if ($userCart === null) {
                $guestCart->update([
                    'user_id' => $user->id,
                    'session_id' => null,
                ]);

                return;
            }

            foreach ($guestItems as $guestItem) {
                $product = $guestItem->product;
                $variant = $guestItem->variant;

                /*
                 * Remove items whose product is no longer active.
                 */
                if (
                    $product === null
                    || !$product->isActive()
                ) {
                    $guestItem->delete();

                    continue;
                }

                /*
                 * A variant cart item must still point to an active
                 * variant belonging to the same product.
                 */
                if ($variant !== null) {
                    if (
                        $variant->product_id !== $product->id
                        || !$variant->isActive()
                    ) {
                        $guestItem->delete();

                        continue;
                    }

                    /*
                     * Guest cart quantities must never exceed the
                     * currently available variant stock.
                     */
                    if ($variant->stock <= 0) {
                        $guestItem->delete();

                        continue;
                    }

                    $guestItem->quantity = min(
                        $guestItem->quantity,
                        $variant->stock,
                    );
                }

                $existingItem = CartItem::query()
                    ->where('cart_id', $userCart->id)
                    ->where('product_id', $guestItem->product_id)
                    ->when(
                        $guestItem->variant_id !== null,
                        function ($query) use ($guestItem): void {
                            $query->where(
                                'variant_id',
                                $guestItem->variant_id,
                            );
                        },
                        function ($query): void {
                            $query->whereNull('variant_id');
                        },
                    )
                    ->lockForUpdate()
                    ->first();

                if ($existingItem === null) {
                    $guestItem->update([
                        'cart_id' => $userCart->id,
                        'quantity' => $guestItem->quantity,
                    ]);

                    continue;
                }

                if ($variant !== null) {
                    $availableQuantity = max(
                        0,
                        $variant->stock - $existingItem->quantity,
                    );

                    if ($availableQuantity <= 0) {
                        $guestItem->delete();

                        continue;
                    }

                    $mergeQuantity = min(
                        $guestItem->quantity,
                        $availableQuantity,
                    );

                    $existingItem->increment(
                        'quantity',
                        $mergeQuantity,
                    );

                    $guestItem->delete();

                    continue;
                }

                $existingItem->increment(
                    'quantity',
                    $guestItem->quantity,
                );

                $guestItem->delete();
            }

            $guestCart->delete();
        });
    }
}
