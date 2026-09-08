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
    Schema::table('products', function (Blueprint $table) {
        if (!Schema::hasColumn('products', 'outfit_type_id')) {
            $table->unsignedBigInteger('outfit_type_id')->nullable()->after('outfit_type');
        }

        if (!Schema::hasColumn('products', 'style_id')) {
            $table->unsignedBigInteger('style_id')->nullable()->after('style');
        }

        if (!Schema::hasColumn('products', 'work_technique_id')) {
            $table->unsignedBigInteger('work_technique_id')->nullable()->after('work_technique');
        }

        if (!Schema::hasColumn('products', 'best_worn_in_id')) {
            $table->unsignedBigInteger('best_worn_in_id')->nullable()->after('best_worn_in');
        }

        if (!Schema::hasColumn('products', 'refund_policy_id')) {
            $table->unsignedBigInteger('refund_policy_id')->nullable()->after('refund_policy');
        }
    });

}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        if (Schema::hasColumn('products', 'outfit_type_id')) {
            $table->dropColumn('outfit_type_id');
        }

        if (Schema::hasColumn('products', 'style_id')) {
            $table->dropColumn('style_id');
        }

        if (Schema::hasColumn('products', 'work_technique_id')) {
            $table->dropColumn('work_technique_id');
        }

        if (Schema::hasColumn('products', 'best_worn_in_id')) {
            $table->dropColumn('best_worn_in_id');
        }

        if (Schema::hasColumn('products', 'refund_policy_id')) {
            $table->dropColumn('refund_policy_id');
        }
    });
}
};
