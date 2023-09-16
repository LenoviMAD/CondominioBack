<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPriceRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiptPriceRecord', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReceipt');
            $table->foreign('idReceipt')->references('id')->on('receipt');
            $table->decimal('price', 10, 2);
            $table->decimal('priceUsd', 10, 2);
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
        Schema::dropIfExists('receiptPriceRecord');
    }
}
