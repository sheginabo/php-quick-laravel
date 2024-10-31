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
        Schema::create('rhino_inventories', function (Blueprint $table) {
            $table->string('sku', 50)->primary();
            $table->boolean('sold_out')->default(false)->index();
            $table->boolean('unlimited')->default(false);
            $table->decimal('original_price'); // New column for original price
            $table->decimal('discount_price')->nullable(); // New column for discount price
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rhino_inventories');
    }
};
