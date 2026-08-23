<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('smart_buy_quote_items', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Quote
            |--------------------------------------------------------------------------
            */

            $table->foreignId('smart_buy_quote_id')
                ->constrained('smart_buy_quotes')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Original Smart Buy Item
            |--------------------------------------------------------------------------
            */

            $table->foreignId('smart_buy_item_id')
                ->nullable()
                ->constrained('smart_buy_items')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->string('product_name');

            $table->unsignedInteger('quantity')
                ->default(1);


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'unit_price',
                15,
                2
            )->default(0);


            $table->decimal(
                'total_price',
                15,
                2
            )->default(0);


            /*
            |--------------------------------------------------------------------------
            | Additional Notes
            |--------------------------------------------------------------------------
            */

            $table->text('notes')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_buy_quote_items');
    }
};
