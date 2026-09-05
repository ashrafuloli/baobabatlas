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
        Schema::create('user_addresses', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('label', 50)
                ->nullable();

            $table->string('first_name', 100);

            $table->string('last_name', 100);

            $table->string('phone', 30);

            $table->string('country', 2);

            $table->string('address', 255);

            $table->string('apartment', 255)
                ->nullable();

            $table->string('city', 100);

            $table->string('state', 100);

            $table->string('postal_code', 20);

            $table->boolean('is_default')
                ->default(false);

            $table->timestamps();

            $table->index([
                'user_id',
                'is_default',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
