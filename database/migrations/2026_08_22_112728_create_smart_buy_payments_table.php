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
        Schema::create('smart_buy_payments', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Smart Buy Request
            |--------------------------------------------------------------------------
            */

            $table->foreignId('smart_buy_request_id')
                ->unique()
                ->constrained('smart_buy_requests')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Smart Buy Quote
            |--------------------------------------------------------------------------
            */

            $table->foreignId('smart_buy_quote_id')
                ->constrained('smart_buy_quotes')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Payment Number
            |--------------------------------------------------------------------------
            */

            $table->string('payment_number')
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Amount
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'amount',
                15,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $table->string('currency', 10)
                ->default('USD');


            /*
            |--------------------------------------------------------------------------
            | Payment Method
            |--------------------------------------------------------------------------
            */

            $table->string('payment_method')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Payment Gateway
            |--------------------------------------------------------------------------
            */

            $table->string('payment_gateway')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Transaction Reference
            |--------------------------------------------------------------------------
            */

            $table->string('transaction_id')
                ->nullable()
                ->index();


            /*
            |--------------------------------------------------------------------------
            | Payment Status
            |--------------------------------------------------------------------------
            |
            | pending
            | processing
            | completed
            | failed
            | cancelled
            | refunded
            |
            */

            $table->string('status')
                ->default('pending')
                ->index();


            /*
            |--------------------------------------------------------------------------
            | Payment Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('paid_at')
                ->nullable();


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
        Schema::dropIfExists('smart_buy_payments');
    }
};
