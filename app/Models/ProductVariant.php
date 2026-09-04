<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_price',
        'stock',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'product_id' => 'integer',
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'stock' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(ProductVariantValue::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'variant_id');
    }

    public function isActive(): bool
    {
        return $this->status === true;
    }
}
