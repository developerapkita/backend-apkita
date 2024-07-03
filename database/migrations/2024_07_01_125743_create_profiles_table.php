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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('profile_id')->primary();
            $table->foreignUlid('user_id');
            $table->string('nik',16)->unique();
            $table->string('address');
            $table->boolean('gender');
            $table->string('birth_city');
            $table->date('birth_date');
            $table->string('phone');
            $table->string('profile_image');
            $table->boolean('is_verified')->default(0);
            $table->integer('saldo')->default(0);
            $table->string('referal_code');
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
