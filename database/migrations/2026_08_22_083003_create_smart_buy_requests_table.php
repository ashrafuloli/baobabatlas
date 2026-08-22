<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('smart_buy_requests', function (Blueprint $table) {

            $table->id();

            // User
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Request Number
            $table->string('request_number')
                ->unique();

            // Customer Information
            $table->string('first_name');

            $table->string('last_name');

            $table->string('phone');

            $table->string('email');

            // Delivery Information
            $table->string('country');

            $table->string('city');

            $table->string('zip_code')
                ->nullable();

            $table->text('delivery_address');

            // Request Status
            $table->string('status')
                ->default('pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('smart_buy_requests');
    }
};
