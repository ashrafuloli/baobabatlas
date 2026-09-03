<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Attribute extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'status',
    ];

    /**
     * Attribute values.
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }
}
