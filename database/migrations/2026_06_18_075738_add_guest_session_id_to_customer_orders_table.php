<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_orders', 'guest_session_id')) {
                $table->string('guest_session_id')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            if (Schema::hasColumn('customer_orders', 'guest_session_id')) {
                $table->dropColumn('guest_session_id');
            }
        });
    }
};