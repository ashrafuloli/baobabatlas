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
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_number', 50)
                ->unique();

            $table->string('status', 30)
                ->default('pending');

            $table->string('payment_status', 30)
                ->default('pending');

            /*
             |--------------------------------------------------------------------------
             | Refund Status
             |--------------------------------------------------------------------------
             |
             | none     = No refund request
             | pending  = Customer requested refund
             | approved = Admin approved refund request
             | rejected = Admin rejected refund request
             | refunded = Stripe refund completed
             |
             */

            $table->string('refund_status', 30)
                ->default('none');

            $table->string('payment_gateway', 30)
                ->nullable();

            $table->string('stripe_checkout_session_id', 255)
                ->nullable()
                ->unique();

            $table->string('stripe_payment_intent_id', 255)
                ->nullable();

            $table->string('currency', 3)
                ->default('usd');

            /*
             |--------------------------------------------------------------------------
             | Order Pricing
             |--------------------------------------------------------------------------
             */

            $table->decimal('subtotal', 12, 2)
                ->default(0);

            $table->decimal('discount', 12, 2)
                ->default(0);

            /*
             |--------------------------------------------------------------------------
             | Final Order Shipping
             |--------------------------------------------------------------------------
             |
             | Total shipping charged for this order.
             | Shipping is non-refundable.
             |
             */

            $table->decimal('shipping', 12, 2)
                ->default(0);

            $table->decimal('tax', 12, 2)
                ->default(0);

            $table->decimal('total', 12, 2)
                ->default(0);

            /*
             |--------------------------------------------------------------------------
             | Customer Contact Snapshot
             |--------------------------------------------------------------------------
             */

            $table->string('first_name', 100);

            $table->string('last_name', 100);

            $table->string('email', 255);

            $table->string('phone', 30);

            /*
             |--------------------------------------------------------------------------
             | Shipping Address Snapshot
             |--------------------------------------------------------------------------
             */

            $table->string('country', 100);

            $table->string('address', 255);

            $table->string('apartment', 255)
                ->nullable();

            $table->string('city', 100);

            $table->string('state', 100)
                ->nullable();

            $table->string('postal_code', 20);

            /*
             |--------------------------------------------------------------------------
             | Order Notes
             |--------------------------------------------------------------------------
             */

            $table->text('notes')
                ->nullable();

            /*
             |--------------------------------------------------------------------------
             | Payment Timestamp
             |--------------------------------------------------------------------------
             */

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamps();

            /*
             |--------------------------------------------------------------------------
             | Indexes
             |--------------------------------------------------------------------------
             */

            $table->index([
                'user_id',
                'status',
            ]);

            $table->index('payment_status');

            $table->index('refund_status');

            $table->index('stripe_payment_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
