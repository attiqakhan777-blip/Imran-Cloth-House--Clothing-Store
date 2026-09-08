<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {

            if (!Schema::hasColumn('customer_orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'first_name')) {
                $table->string('first_name')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'last_name')) {
                $table->string('last_name')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'apartment')) {
                $table->string('apartment')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'city')) {
                $table->string('city')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'postal_code')) {
                $table->string('postal_code')->nullable();
            }

            if (!Schema::hasColumn('customer_orders', 'country')) {
                $table->string('country')->default('Pakistan');
            }

            if (!Schema::hasColumn('customer_orders', 'shipping_method')) {
                $table->string('shipping_method')->default('Standard');
            }

            if (!Schema::hasColumn('customer_orders', 'shipping_charges')) {
                $table->decimal('shipping_charges', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('customer_orders', 'tax_charges')) {
                $table->decimal('tax_charges', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('customer_orders', 'handling_charges')) {
                $table->decimal('handling_charges', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('customer_orders', 'payment_method')) {
                $table->string('payment_method')->default('COD');
            }

            if (!Schema::hasColumn('customer_orders', 'billing_address')) {
                $table->string('billing_address')->default('same');
            }

            if (!Schema::hasColumn('customer_orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('customer_orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0);
            }

        });
    }

    public function down(): void
    {
        //
    }
};