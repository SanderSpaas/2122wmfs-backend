<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up()
    {
        Schema::create('players', function ($table) {

            $table->id();
            $table->integer('kills',)->nullable();
            $table->unsignedBigInteger('game_id',);
            $table->unsignedBigInteger('user_id',);
            $table->unsignedBigInteger('target_id',);
            $table->unsignedBigInteger('chat_id',);
            $table->boolean('dead',)->nullable();
            $table->boolean('won',)->nullable();
        });

        Schema::table('players', function (Blueprint $table) {

            $table->foreign('chat_id')->references('id')->on('chats');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('target_id')->references('id')->on('players');
        });

    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
