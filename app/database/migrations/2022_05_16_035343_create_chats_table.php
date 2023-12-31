<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        Schema::create('chats', function ($table) {

            $table->id();
            $table->datetime('send_at')->nullable();
            $table->string('message', 250)->nullable();
            $table->unsignedBigInteger('game_id')->onDelete('cascade');
            $table->unsignedBigInteger('player_id')->onDelete('cascade');
        });

        Schema::table('chats', function (Blueprint $table) {

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
