<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class WishlistItem extends Model
{
    protected $fillable = [
        'wishlist_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'wishlist_id' => 'integer',
            'product_id' => 'integer',
        ];
    }

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
