<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('outfit_type')->nullable()->after('gender');
            $table->string('style')->nullable()->after('outfit_type');
            $table->string('color_type')->nullable()->after('style');
            $table->string('color_type_custom')->nullable()->after('color_type');
            $table->string('work_technique')->nullable()->after('color_type_custom');
            $table->string('best_worn_in')->nullable()->after('work_technique');
            $table->string('refund_policy')->nullable()->after('best_worn_in');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'outfit_type',
                'style',
                'color_type',
                'color_type_custom',
                'work_technique',
                'best_worn_in',
                'refund_policy'
            ]);
        });
    }
};