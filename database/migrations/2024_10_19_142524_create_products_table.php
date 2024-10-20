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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0);
            $table->string('product_name', 200)->default('');
            $table->string('sku', 100)->unique();
            $table->text('desc')->nullable();
            $table->decimal('price', 26, 8)->default(0.00000000);
            $table->integer('stock_quantity')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->string('tags', 255)->nullable();
            $table->decimal('cost_price', 26, 8)->nullable();
            $table->tinyInteger('is_published')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
