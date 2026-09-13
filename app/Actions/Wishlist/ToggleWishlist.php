<?php

declare(strict_types=1);

namespace App\Actions\Wishlist;

use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

final class ToggleWishlist
{
    public function execute(int $userId, int $productId): bool
    {
        return DB::transaction(
            function () use ($userId, $productId): bool {
                $wishlist = Wishlist::query()
                    ->firstOrCreate([
                        'user_id' => $userId,
                    ]);

                $wishlistItem = $wishlist->items()
                    ->where('product_id', $productId)
                    ->first();

                if ($wishlistItem !== null) {
                    $wishlistItem->delete();

                    return false;
                }

                $wishlist->items()->create([
                    'product_id' => $productId,
                ]);

                return true;
            },
        );
    }
}
