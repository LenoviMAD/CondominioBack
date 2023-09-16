<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idResidential');
            $table->foreign('idResidential')->references('id')->on('residential');
            $table->integer('status');
            $table->foreign('status')->references('id')->on('entitySubClass');
            $table->string('number');
            $table->date('date');
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
        Schema::dropIfExists('receipt');
    }
}
