<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class InventoryTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'type',
        'quantity',
        'reference',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'product_variant_id' => 'integer',
            'quantity' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id',
        );
    }

    public function isIncrease(): bool
    {
        return $this->quantity > 0;
    }

    public function isDecrease(): bool
    {
        return $this->quantity < 0;
    }
}
