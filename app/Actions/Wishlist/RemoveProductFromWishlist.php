<?php

declare(strict_types=1);

namespace App\Actions\Wishlist;

use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

final class RemoveProductFromWishlist
{
    public function execute(int $userId, int $productId): bool
    {
        return DB::transaction(
            function () use ($userId, $productId): bool {
                $wishlist = Wishlist::query()
                    ->where('user_id', $userId)
                    ->first();

                if ($wishlist === null) {
                    return false;
                }

                return $wishlist->items()
                        ->where('product_id', $productId)
                        ->delete() > 0;
            },
        );
    }
}
