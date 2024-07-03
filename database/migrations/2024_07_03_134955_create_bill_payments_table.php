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
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->uuid('bill_payment_id')->primary();
            $table->foreignUlid('bill_id');
            $table->string('invoice_number');
            $table->bigInteger('amount');
            $table->string('midtrans_token');
            $table->string('midtrans_url');
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
        Schema::dropIfExists('bill_payments');
    }
};
