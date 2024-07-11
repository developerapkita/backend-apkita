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
            $table->id('id');
            $table->integer('user_id');
            $table->uuid('slug')->unique()->default(DB::raw('(UUID())'));
            $table->string('nik',16)->unique()->nullable();
            $table->string('address')->nullable();
            $table->integer('province')->nullable();
            $table->integer('regencies')->nullable();
            $table->integer('districts')->nullable();
            $table->enum('gender',['L','P'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->dateTime('verified_at')->nullable();
            $table->integer('saldo')->default(0);
            $table->string('referal_code')->nullable();
            $table->string('referal_code_inviter')->nullable();
            $table->dateTime('commision_at')->nullable();
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
