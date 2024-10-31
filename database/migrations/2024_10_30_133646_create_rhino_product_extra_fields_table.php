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
        Schema::create('rhino_product_extra_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // 先定義 product_id 欄位
            $table->foreign('product_id')->references('id')->on('rhino_products')->onDelete('cascade'); // 然後設置外鍵約束
            $table->string('name', 255);
            $table->text('desc')->nullable();
            $table->boolean('stock_impact');
            $table->string('field_type', 50);
            $table->string('display_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rhino_product_extra_fields');
    }
};
