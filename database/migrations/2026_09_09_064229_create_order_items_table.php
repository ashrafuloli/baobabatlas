<?php

declare(strict_types=1);

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
        Schema::create('order_items', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            /*
             |--------------------------------------------------------------------------
             | Product Snapshot
             |--------------------------------------------------------------------------
             */

            $table->string('product_name', 255);

            $table->string('sku', 100)
                ->nullable();

            $table->string('image', 500)
                ->nullable();

            /*
             |--------------------------------------------------------------------------
             | Pricing Snapshot
             |--------------------------------------------------------------------------
             */

            $table->unsignedInteger('quantity');

            $table->decimal('unit_price', 12, 2);

            $table->decimal('line_total', 12, 2);

            $table->timestamps();

            $table->index('order_id');

            $table->index('product_id');

            $table->index('variant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
