<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->string('sku')
                ->nullable()
                ->unique();

            $table->string('source', 20)
                ->default('own');

            $table->string('thumbnail')
                ->nullable();

            $table->string('video_url')
                ->nullable();

            $table->text('short_description')
                ->nullable();

            $table->longText('description')
                ->nullable();

            $table->decimal('price', 12, 2);

            $table->decimal('compare_price', 12, 2)
                ->nullable();

            $table->decimal('cost_price', 12, 2)
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->boolean('featured')
                ->default(false);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->string('meta_title')
                ->nullable();

            $table->text('meta_description')
                ->nullable();

            $table->timestamps();

            $table->index('brand_id');
            $table->index('source');
            $table->index('status');
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
