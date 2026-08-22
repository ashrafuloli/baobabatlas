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
        Schema::create('smart_buy_items', function (Blueprint $table) {

            $table->id();

            // Parent Smart Buy Request
            $table->foreignId('smart_buy_request_id')
                ->constrained('smart_buy_requests')
                ->cascadeOnDelete();

            // Product Information
            $table->string('product_url');

            $table->string('product_name');

            $table->unsignedInteger('quantity')
                ->default(1);

            $table->string('size')
                ->nullable();

            $table->string('color')
                ->nullable();

            // Product Image
            $table->string('product_image')
                ->nullable();

            // Additional Notes
            $table->text('notes')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_buy_items');
    }
};
