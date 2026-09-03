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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();


            /*
            |--------------------------------------------------------------------------
            | Parent Category
            |--------------------------------------------------------------------------
            |
            | NULL = Main Category
            | ID   = Subcategory
            |
            */

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Category Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('slug')
                ->unique();

            $table->string('image')
                ->nullable();

            $table->text('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Sorting
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('sort_order')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | Status & Featured
            |--------------------------------------------------------------------------
            */

            $table->boolean('status')
                ->default(true);

            $table->boolean('featured')
                ->default(false);


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')
                ->nullable();

            $table->text('meta_description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('parent_id');

            $table->index('status');

            $table->index('featured');

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
