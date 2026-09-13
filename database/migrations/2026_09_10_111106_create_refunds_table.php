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
        Schema::create('refunds', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('order_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('refund_request_id')
                ->nullable()
                ->unique()
                ->constrained()
                ->nullOnDelete();

            $table->string('stripe_refund_id', 255)
                ->nullable()
                ->unique();

            $table->string('stripe_idempotency_key', 255)
                ->unique();

            $table->decimal('amount', 12, 2);

            $table->string('currency', 3);

            $table->string('status', 30);

            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
