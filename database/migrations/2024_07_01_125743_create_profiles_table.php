<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('id')->primary();
            $table->integer('user_id');
            $table->uuid('slug')->unique()->default(DB::raw('(UUID())'));
            $table->string('nik',16)->unique();
            $table->string('address');
            $table->enum('gender',['L','P']);
            $table->date('birth_date');
            $table->string('image');
            $table->boolean('is_verified')->default(0);
            $table->dateTime('verified_at');
            $table->integer('saldo')->default(0);
            $table->string('referal_code');
            $table->string('referal_code_inviter');
            $table->dateTime('commision_at');
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
        Schema::dropIfExists('profiles');
    }
};
