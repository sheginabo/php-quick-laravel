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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('訂單ID');
            $table->foreignId('bnb_id')->constrained('bnbs')->comment('旅宿ID');
            $table->foreignId('room_id')->constrained('rooms')->comment('房間ID');
            $table->char('currency', 3)->comment('付款幣別，值為:TWD (台幣), USD (美金), JPY (日圓)');
            $table->integer('amount')->comment('訂單金額');
            $table->date('check_in_date')->comment('入住日');
            $table->date('check_out_date')->comment('退房日');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
