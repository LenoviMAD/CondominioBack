<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configPay', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idResidential')->unique();
            $table->foreign('idResidential')->references('id')->on('residential');
            $table->string('payDay');
            $table->string('publishDay');
            $table->string('delinquencyAllowed');
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
        Schema::dropIfExists('configPay');
    }
}
