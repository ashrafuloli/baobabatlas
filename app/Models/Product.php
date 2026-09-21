<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Product extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'sku',
        'type',
        'source',
        'thumbnail',
        'video_url',
        'short_description',
        'description',
        'price',
        'compare_price',
        'cost_price',
        'shipping_cost',
        'stock',
        'status',
        'featured',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'brand_id' => 'integer',
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'cost_price' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'stock' => 'integer',
            'sort_order' => 'integer',
            'status' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'product_categories',
        )->withTimestamps();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(
            Wishlist::class,
            'wishlist_items',
            'product_id',
            'wishlist_id',
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(
        Builder $query,
    ): Builder {
        return $query->where(
            'status',
            true,
        );
    }

    public function scopeFeatured(
        Builder $query,
    ): Builder {
        return $query->where(
            'featured',
            true,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Product Type
    |--------------------------------------------------------------------------
    */

    public function isSimple(): bool
    {
        return $this->type === 'simple';
    }

    public function isVariable(): bool
    {
        return $this->type === 'variable';
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === true;
    }

    public function isFeatured(): bool
    {
        return $this->featured === true;
    }

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    public function hasVariants(): bool
    {
        return $this->variants()->exists();
    }
}
