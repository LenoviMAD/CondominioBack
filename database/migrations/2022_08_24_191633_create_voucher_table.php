<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReceiptDetail')->nullable();
            $table->foreign('idReceiptDetail')->references('id')->on('receiptDetail');
            $table->integer('idCreditor');
            $table->foreign('idCreditor')->references('id')->on('creditor');
            $table->integer('idTypePayment');
            $table->foreign('idTypePayment')->references('id')->on('entitySubClass');
            $table->string('reference');
            $table->date('date');
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->boolean('favorite');
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
        Schema::dropIfExists('voucher');
    }
}