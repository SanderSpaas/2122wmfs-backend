<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->nullable()->default('NULL');
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->string('murder_method', 45)->nullable()->default('NULL');
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
