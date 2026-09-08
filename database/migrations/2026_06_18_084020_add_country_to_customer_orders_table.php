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
    Schema::table('customer_orders', function (Blueprint $table) {
        if (!Schema::hasColumn('customer_orders', 'country')) {
            $table->string('country')->nullable()->after('email');
        }

        if (!Schema::hasColumn('customer_orders', 'shipping_method')) {
            $table->string('shipping_method')->nullable()->after('phone');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            //
        });
    }
};
