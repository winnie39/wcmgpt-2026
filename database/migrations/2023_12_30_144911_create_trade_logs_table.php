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
        Schema::create('trade_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->decimal('rate', 20, 6)->nullable();
            $table->string('symbol')->default('BTCUSDT');
            $table->string('type')->default('BUY');
            $table->string('order_id')->default(0);
            $table->dateTime('bot_opening_time')->default(now());
            $table->dateTime('bot_closing_time')->default(now());
            $table->string('session_close_time')->default(0);
            $table->string('session_open_time')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_logs');
    }
};
