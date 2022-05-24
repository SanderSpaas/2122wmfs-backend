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
            $table->string('alias');
            $table->integer('kills',)->default('0');
            $table->unsignedBigInteger('game_id',);
            $table->unsignedBigInteger('user_id',);
            $table->unsignedBigInteger('killer_id',)->nullable();
            $table->unsignedBigInteger('target_id',)->nullable();
            $table->boolean('dead',)->default('0');
            $table->boolean('won',)->default('0');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('target_id')->references('id')->on('players');
            $table->foreign('killer_id')->references('id')->on('players');
        });

    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
