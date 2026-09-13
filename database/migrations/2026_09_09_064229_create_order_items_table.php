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
             | Quantity
             |--------------------------------------------------------------------------
             */

            $table->unsignedInteger('quantity');

            /*
             |--------------------------------------------------------------------------
             | Pricing Snapshot
             |--------------------------------------------------------------------------
             */

            $table->decimal('unit_price', 12, 2);

            /*
             |--------------------------------------------------------------------------
             | Shipping Cost Snapshot
             |--------------------------------------------------------------------------
             |
             | Product shipping cost at the time the order was created.
             |
             | This is charged once per order item line.
             | It is NOT multiplied by quantity.
             |
             */

            $table->decimal('shipping_cost', 12, 2)
                ->default(0);

            /*
             |--------------------------------------------------------------------------
             | Product Line Total
             |--------------------------------------------------------------------------
             |
             | Product price × quantity.
             |
             | Shipping is stored separately in shipping_cost.
             |
             */

            $table->decimal('line_total', 12, 2);

            $table->timestamps();

            /*
             |--------------------------------------------------------------------------
             | Indexes
             |--------------------------------------------------------------------------
             */

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
