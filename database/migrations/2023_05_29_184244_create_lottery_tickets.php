<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lottery_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lottery_id')->constrained();
            $table->foreignId('lottery_player_id')->constrained();
            $table->integer('ticket_number');
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lottery_tickets');
    }
};
