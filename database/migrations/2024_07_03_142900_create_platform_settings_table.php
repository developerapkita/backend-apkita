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
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->uuid('platform_setting_id');
            $table->string('version_mobile');
            $table->string('version_website');
            $table->string('phone');
            $table->string('address');
            $table->string('data');
            $table->boolean('is_read');
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
        Schema::dropIfExists('platform_settings');
    }
};
