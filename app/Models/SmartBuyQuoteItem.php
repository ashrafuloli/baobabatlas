<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartBuyQuoteItem extends Model
{
    use HasFactory;


    /*
    |--------------------------------------------------------------------------
    | Mass Assignable Fields
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'smart_buy_quote_id',

        'smart_buy_item_id',

        'product_name',

        'quantity',

        'unit_price',

        'total_price',

        'notes',

    ];


    /*
    |--------------------------------------------------------------------------
    | Attribute Casting
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'quantity' =>
            'integer',

        'unit_price' =>
            'decimal:2',

        'total_price' =>
            'decimal:2',

    ];


    /*
    |--------------------------------------------------------------------------
    | Smart Buy Quote
    |--------------------------------------------------------------------------
    */

    public function quote(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyQuote::class,
            'smart_buy_quote_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Original Smart Buy Item
    |--------------------------------------------------------------------------
    */

    public function smartBuyItem(): BelongsTo
    {
        return $this->belongsTo(
            SmartBuyItem::class,
            'smart_buy_item_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Calculate Total Price
    |--------------------------------------------------------------------------
    */

    public function calculateTotalPrice(): float
    {
        return

            (float)
            $this->unit_price

            *

            (int)
            $this->quantity;
    }


    /*
    |--------------------------------------------------------------------------
    | Refresh Total Price
    |--------------------------------------------------------------------------
    */

    public function refreshTotalPrice(): bool
    {
        return $this->update([

            'total_price' =>
                $this->calculateTotalPrice(),

        ]);
    }
}
