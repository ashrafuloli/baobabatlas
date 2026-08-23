<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmartBuyItem extends Model
{
    /**
     * Mass Assignable Fields
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
     * Attribute Casting
     */
    protected $casts = [
        'quantity' => 'integer',
    ];


    /**
     * Smart Buy Request
     */
    public function smartBuyRequest(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyRequest::class,
            'smart_buy_request_id'
        );
    }


    /**
     * Quote Items
     */
    public function quoteItems(): HasMany
    {
        return $this->hasMany(
            SmartBuyQuoteItem::class,
            'smart_buy_item_id'
        );
    }
}
