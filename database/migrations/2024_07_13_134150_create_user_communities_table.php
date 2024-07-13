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
        Schema::create('user_communities', function (Blueprint $table) {
            $table->id('id');
            $table->integer('user_id');
            $table->integer('inviter_id');
            $table->integer('community_id');
            $table->enum('role',['admin','manager','support','member']);
            $table->boolean('is_owner')->default(0);
            $table->boolean('is_accept')->default(0);
            $table->dateTime('responded_at');
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
        Schema::dropIfExists('user_communities');
    }
};
