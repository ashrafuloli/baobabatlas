<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class Brand extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
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
            'sort_order' => 'integer',
            'status' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    /**
     * Scope: Active brands only.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope: Featured brands only.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Check if brand is active.
     */
    public function isActive(): bool
    {
        return $this->status === true;
    }

    /**
     * Check if brand is featured.
     */
    public function isFeatured(): bool
    {
        return $this->featured === true;
    }
}
