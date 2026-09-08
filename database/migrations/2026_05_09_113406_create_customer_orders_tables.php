<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // UNIQUE NUMBERS
            $table->string('order_number')->unique();

            $table->string('tracking_number')->unique();

            // CUSTOMER INFO
            $table->string('email')->nullable();

            $table->string('country')->default('Pakistan');

            $table->string('first_name')->nullable();

            $table->string('last_name')->nullable();

            $table->string('address');

            $table->string('apartment')->nullable();

            $table->string('city');

            $table->string('postal_code')->nullable();

            $table->string('phone');

            // SHIPPING
            $table->string('shipping_method')
                ->default('Standard');

            $table->decimal('shipping_charges', 10, 2)
                ->default(0);

            // TAX & HANDLING
            $table->decimal('tax_charges', 10, 2)
                ->default(0);

            $table->decimal('handling_charges', 10, 2)
                ->default(0);

            // PAYMENT
            $table->string('payment_method')
                ->default('Cash on Delivery');

            $table->string('billing_address')
                ->default('same');

            // TOTALS
            $table->decimal('subtotal', 10, 2)
                ->default(0);

            $table->decimal('total_amount', 10, 2)
                ->default(0);

            // STATUS
            $table->enum('status', [

                'pending',
                'processing',
                'shipped',
                'delivered',
                'cancelled',

            ])->default('pending');

            $table->timestamps();
        });

        Schema::create('customer_order_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('customer_order_id')
                ->constrained('customer_orders')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            $table->string('product_name');

            $table->string('product_slug')->nullable();

            $table->string('size')->nullable();

            $table->string('image')->nullable();

            $table->decimal('price', 10, 2);

            $table->integer('quantity');

            $table->decimal('line_total', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_order_items');

        Schema::dropIfExists('customer_orders');
    }
};