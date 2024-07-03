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
        Schema::create('contributions', function (Blueprint $table) {
            $table->uuid('contribution_id')->primary();
            $table->foreignUlid('community_id');
            $table->string('name');
            $table->enum('type',['routine','not_routine','voluntary']);
            $table->bigInteger('amount');
            $table->timestamp('deadline');
            $table->enum('status',[]);
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
        Schema::dropIfExists('contributions');
    }
};
