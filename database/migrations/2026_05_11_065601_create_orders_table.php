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

            // avoid foreign key crash (most common issue)
            $table->unsignedBigInteger('customer_id')->nullable();

            $table->string('order_number')->unique();
            $table->string('tracking_number')->nullable();

            $table->string('email');
            $table->string('country');
            $table->string('first_name')->nullable();
            $table->string('last_name');

            $table->text('address');
            $table->string('apartment')->nullable();
            $table->string('city');
            $table->string('postal_code')->nullable();
            $table->string('phone');

            $table->string('shipping_method')->nullable();

            $table->decimal('shipping_charges', 10, 2)->default(0);
            $table->decimal('tax_charges', 10, 2)->default(0);
            $table->decimal('handling_charges', 10, 2)->default(0);

            $table->string('payment_method');
            $table->text('billing_address');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};