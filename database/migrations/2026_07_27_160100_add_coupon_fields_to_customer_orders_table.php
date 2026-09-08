<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_orders', 'coupon_code')) {
                $table->string('coupon_code', 6)->nullable()->after('subtotal');
            }
            if (!Schema::hasColumn('customer_orders', 'coupon_discount')) {
                $table->decimal('coupon_discount', 10, 2)->default(0)->after('coupon_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            if (Schema::hasColumn('customer_orders', 'coupon_discount')) {
                $table->dropColumn('coupon_discount');
            }
            if (Schema::hasColumn('customer_orders', 'coupon_code')) {
                $table->dropColumn('coupon_code');
            }
        });
    }
};
