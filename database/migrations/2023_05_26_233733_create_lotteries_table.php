<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('maximum_tickets_per_player');
            $table->integer('starting_price')->default(0);
            $table->integer('current_price')->default(0);
            $table->integer('ticket_price')->default(100);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotteries');
    }
};
