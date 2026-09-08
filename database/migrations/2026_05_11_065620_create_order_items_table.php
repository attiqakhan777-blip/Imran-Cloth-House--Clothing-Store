<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    if (!Schema::hasTable('customer_order_items')) {
        Schema::create('customer_order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_order_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();

            $table->string('product_name');
            $table->string('size')->nullable();

            $table->decimal('price', 12, 2);
            $table->integer('quantity');
            $table->string('image')->nullable();

            $table->decimal('line_total', 12, 2);

            $table->timestamps();
        });
    }
}

    public function down(): void
    {
        Schema::dropIfExists('customer_order_items');
    }
};