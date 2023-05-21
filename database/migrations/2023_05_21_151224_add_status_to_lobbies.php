<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToLobbies extends Migration
{
    public function up()
    {
        Schema::table('lobbies', function (Blueprint $table) {
            $table->string('status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lobbies', function (Blueprint $table) {
            //
        });
    }
};
