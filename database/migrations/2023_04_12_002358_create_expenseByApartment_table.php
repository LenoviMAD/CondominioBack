<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseByApartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenseByApartment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idApartment');
            $table->foreign('idApartment')->references('id')->on('apartment');
            $table->integer('idReceiptDetail');
            $table->foreign('idReceiptDetail')->references('id')->on('receiptDetail');
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
        Schema::dropIfExists('expenseByApartment');
    }
}