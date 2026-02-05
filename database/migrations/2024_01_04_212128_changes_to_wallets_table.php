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
        Schema::table('wallets', function (Blueprint $table) {
            $table->decimal('stop_bot', 20, 4)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
        });
    }
};
