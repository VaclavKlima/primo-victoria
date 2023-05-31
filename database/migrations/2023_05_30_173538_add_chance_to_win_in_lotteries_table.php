<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->integer('chance_to_win')->default(50);
        });
    }

    public function down(): void
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->dropColumn('chance_to_win');
        });
    }
};
