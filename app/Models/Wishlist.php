<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function hasProduct(int $productId): bool
    {
        return $this->items()
            ->where('product_id', $productId)
            ->exists();
    }

    public function addProduct(int $productId): WishlistItem
    {
        return $this->items()->firstOrCreate([
            'product_id' => $productId,
        ]);
    }

    public function removeProduct(int $productId): int
    {
        return $this->items()
            ->where('product_id', $productId)
            ->delete();
    }
}
