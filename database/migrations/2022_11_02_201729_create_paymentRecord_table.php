<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentRecord', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idApartment');
            $table->foreign('idApartment')->references('id')->on('apartment');
            $table->integer('idReceipt');
            $table->foreign('idReceipt')->references('id')->on('receipt');
            $table->integer('status');
            $table->foreign('status')->references('id')->on('entitySubClass');
            $table->decimal('amountPaymentBs', 10, 2);
            $table->decimal('amountPaymentUsd', 10, 2);
            $table->decimal('amountPaidUserBs', 10, 2)->nullable();
            $table->decimal('amountPaidUserUsd', 10, 2)->nullable();
            $table->date('datePaid')->nullable();
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
        Schema::dropIfExists('paymentRecord');
    }
}
