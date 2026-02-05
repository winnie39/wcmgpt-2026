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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->decimal('amount', 20, 5)->default(0);
            $table->decimal('amount_before_deduction', 20, 5)->default(0);
            $table->string('description')->nullable();
            $table->string('string')->nullable();
            $table->string('code')->nullable();
            $table->integer('status')->nullable();
            $table->integer('type')->nullable();
            $table->string('address')->default('LARGER BANK');
            $table->string('method')->default('LARGER BANK');
            $table->string('wallet')->default('deposit');
            $table->string('currency')->default('USD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
