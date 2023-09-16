<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPaymentRecord');
            $table->foreign('idPaymentRecord')->references('id')->on('paymentRecord');
            $table->integer('idPaymentMethod');
            $table->foreign('idPaymentMethod')->references('id')->on('entitySubClass');
            $table->integer('idBank');
            $table->foreign('idBank')->references('id')->on('entitySubClass');
            $table->string('paymentInstrument');
            $table->string('name');
            $table->string('ci');
            $table->string('referenceNumber');
            $table->date('paidDay');
            $table->decimal('amountPaidBs', 10, 2);
            $table->decimal('amountPaidUsd', 10, 2);
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
        Schema::dropIfExists('payment');
    }
}
