<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->foreignId('outfit_type_id')->nullable()->constrained('attributes');
        $table->foreignId('style_id')->nullable()->constrained('attributes');
        $table->foreignId('work_technique_id')->nullable()->constrained('attributes');
        $table->foreignId('best_worn_in_id')->nullable()->constrained('attributes');
        $table->foreignId('refund_policy_id')->nullable()->constrained('attributes');

        // Optional: Drop old string columns later
        // $table->dropColumn(['style', 'work_technique', 'best_worn_in', 'outfit_type', 'refund_policy']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
