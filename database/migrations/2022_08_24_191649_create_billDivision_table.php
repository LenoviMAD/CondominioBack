<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillDivisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billDivision', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReceiptDetail');
            $table->foreign('idReceiptDetail')->references('id')->on('receiptDetail');
            $table->integer('installmentPaid');
            $table->integer('installmentFraction');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('description');
            $table->decimal('amountInstallmentBs', 10, 2);
            $table->decimal('amountInstallmentUsd', 10, 2);
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
        Schema::dropIfExists('billDivision');
    }
}
