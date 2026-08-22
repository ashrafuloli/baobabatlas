<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmartBuyRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'request_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'country',
        'city',
        'zip_code',
        'delivery_address',
        'status',
    ];

    /**
     * Get the user that owns this Smart Buy Request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items for this Smart Buy Request.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SmartBuyItem::class);
    }
}
