<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_communitys', function (Blueprint $table) {
            $table->uuid('user_community_id')->primary();
            $table->foreignUlid('user_id');
            $table->foreignUlid('community_id');
            $table->enum('role',['manajer','admin','support']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_communitys');
    }
};
