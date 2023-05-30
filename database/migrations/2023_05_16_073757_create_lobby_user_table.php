<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLobbyUserTable extends Migration
{
    public function up()
    {
        Schema::create('lobby_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lobby_id');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('lobby_id')->references('id')->on('lobbies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lobby_user');
    }
}
