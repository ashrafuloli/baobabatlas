<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'first_name',
        'last_name',
        'phone',
        'country',
        'address',
        'apartment',
        'city',
        'state',
        'postal_code',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'is_default' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
