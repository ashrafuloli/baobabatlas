<?php

declare(strict_types=1);

namespace App\Actions\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class AddProductToWishlist
{
    public function execute(int $userId, int $productId): WishlistItem
    {
        return DB::transaction(
            function () use ($userId, $productId): WishlistItem {
                $product = Product::query()
                    ->whereKey($productId)
                    ->first();

                if ($product === null) {
                    throw new RuntimeException(
                        'The selected product could not be found.',
                    );
                }

                $wishlist = Wishlist::query()
                    ->firstOrCreate([
                        'user_id' => $userId,
                    ]);

                $wishlistItem = WishlistItem::query()
                    ->firstOrCreate([
                        'wishlist_id' => $wishlist->id,
                        'product_id' => $product->id,
                    ]);

                return $wishlistItem->fresh([
                    'product',
                ]);
            },
        );
    }
}
