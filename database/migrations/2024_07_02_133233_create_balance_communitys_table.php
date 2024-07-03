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
        Schema::create('balance_communitys', function (Blueprint $table) {
            $table->uuid('balance_community_id')->primary();
            $table->foreignUlid('community_id');
            $table->bigInteger('debit');
            $table->bigInteger('credit');
            $table->bigInteger('balance');
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
        Schema::dropIfExists('balance_communitys');
    }
};
