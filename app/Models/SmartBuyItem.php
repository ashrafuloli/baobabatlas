<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartBuyItem extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'smart_buy_request_id',
        'product_url',
        'product_name',
        'quantity',
        'size',
        'color',
        'product_image',
        'notes',
    ];

    /**
     * Get the Smart Buy Request that owns this item.
     */
    public function smartBuyRequest(): BelongsTo
    {
        return $this->belongsTo(SmartBuyRequest::class);
    }
}
