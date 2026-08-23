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
        Schema::create('smart_buy_shipments', function (Blueprint $table) {

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
            | Shipment Information
            |--------------------------------------------------------------------------
            */

            $table->string('tracking_number')
                ->nullable()
                ->index();

            $table->string('carrier')
                ->nullable();

            $table->string('tracking_url')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Shipping Status
            |--------------------------------------------------------------------------
            |
            | pending
            | preparing
            | shipped
            | in_transit
            | delivered
            | cancelled
            |
            */

            $table->string('status')
                ->default('pending')
                ->index();


            /*
            |--------------------------------------------------------------------------
            | Shipping Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('shipped_at')
                ->nullable();

            $table->timestamp('estimated_delivery_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Delivery Information
            |--------------------------------------------------------------------------
            */

            $table->string('country')
                ->nullable();

            $table->string('city')
                ->nullable();

            $table->string('zip_code')
                ->nullable();

            $table->text('delivery_address')
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
        Schema::dropIfExists('smart_buy_shipments');
    }
};
