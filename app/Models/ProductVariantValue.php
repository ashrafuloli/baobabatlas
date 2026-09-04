<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductVariantValue extends Model
{
    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_value_id',
    ];

    protected function casts(): array
    {
        return [
            'product_variant_id' => 'integer',
            'attribute_id' => 'integer',
            'attribute_value_id' => 'integer',
        ];
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(
            ProductVariant::class,
            'product_variant_id',
        );
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(
            AttributeValue::class,
            'attribute_value_id',
        );
    }
}
