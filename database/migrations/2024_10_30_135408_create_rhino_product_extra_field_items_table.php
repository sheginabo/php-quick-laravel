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
        Schema::create('rhino_product_extra_field_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id'); // 先定義 field_id 欄位
            $table->foreign('field_id')->references('id')->on('rhino_product_extra_fields')->onDelete('cascade');
            $table->string('sku_part', 50);
            $table->string('value', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rhino_product_extra_field_items');
    }
};
