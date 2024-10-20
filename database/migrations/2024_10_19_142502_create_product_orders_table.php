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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0);
            $table->string('currency', 10)->nullable();
            $table->string('type', 20)->nullable();
            $table->decimal('tax_amount', 26, 8)->nullable();
            $table->decimal('total_amount', 26, 8)->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('billing_email', 320)->nullable();
            $table->dateTime('date_created_gmt')->nullable();
            $table->dateTime('date_updated_gmt')->nullable();
            $table->string('payment_method', 100)->nullable();
            $table->text('payment_method_title')->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('ip_address', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('customer_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
