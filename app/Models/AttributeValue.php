<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AttributeValue extends Model
{
    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'attribute_id',
        'label',
        'value',
        'slug',
        'sort_order',
        'status',
    ];

    /**
     * Parent attribute.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'attribute_id' => 'integer',
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }
}
