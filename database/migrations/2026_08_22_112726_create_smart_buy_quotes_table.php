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
        Schema::create('smart_buy_quotes', function (Blueprint $table) {

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
            | Quote Number
            |--------------------------------------------------------------------------
            */

            $table->string('quote_number')
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal(
                'product_total',
                15,
                2
            )->default(0);


            $table->decimal(
                'service_fee',
                15,
                2
            )->default(0);


            $table->decimal(
                'shipping_fee',
                15,
                2
            )->default(0);


            $table->decimal(
                'total_amount',
                15,
                2
            )->default(0);


            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $table->string('currency', 10)
                ->default('USD');


            /*
            |--------------------------------------------------------------------------
            | Quote Status
            |--------------------------------------------------------------------------
            |
            | draft
            | sent
            | accepted
            | rejected
            | expired
            |
            */

            $table->string('status')
                ->default('draft')
                ->index();


            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */

            $table->text('notes')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Quote Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('sent_at')
                ->nullable();

            $table->timestamp('accepted_at')
                ->nullable();

            $table->timestamp('rejected_at')
                ->nullable();

            $table->timestamp('expires_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Created By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


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
        Schema::dropIfExists('smart_buy_quotes');
    }
};
