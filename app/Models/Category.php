<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'description',
        'sort_order',
        'status',
        'featured',
        'meta_title',
        'meta_description',
    ];


    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'parent_id' => 'integer',
            'sort_order' => 'integer',
            'status' => 'boolean',
            'featured' => 'boolean',
        ];
    }


    /**
     * Parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'parent_id'
        );
    }


    /**
     * Child categories / subcategories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            self::class,
            'parent_id'
        )->orderBy('sort_order');
    }


    /**
     * Scope: Main categories only.
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }


    /**
     * Scope: Subcategories only.
     */
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }


    /**
     * Scope: Active categories only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }


    /**
     * Scope: Featured categories only.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }


    /**
     * Check if this is a main category.
     */
    public function isMain(): bool
    {
        return is_null($this->parent_id);
    }


    /**
     * Check if this is a subcategory.
     */
    public function isSubcategory(): bool
    {
        return !is_null($this->parent_id);
    }


    /**
     * Check if category is active.
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }


    /**
     * Check if category is featured.
     */
    public function isFeatured(): bool
    {
        return $this->featured === true;
    }
}
