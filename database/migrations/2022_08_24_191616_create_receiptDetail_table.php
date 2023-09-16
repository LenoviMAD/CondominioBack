<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receiptDetail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idReceipt');
            $table->foreign('idReceipt')->references('id')->on('receipt');
            $table->integer('idTypeExpense');
            $table->foreign('idTypeExpense')->references('id')->on('entitySubClass');
            $table->string('item');
            $table->decimal('price', 10, 2);
            $table->decimal('priceUsd', 10, 2);
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
        Schema::dropIfExists('receiptDetail');
    }
}
