<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankResidentialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankResidential', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idResidential');
            $table->foreign('idResidential')->references('id')->on('residential');
            $table->integer('idBank');
            $table->foreign('idBank')->references('id')->on('entitySubClass');
            $table->integer('idTypeAccount');
            $table->foreign('idTypeAccount')->references('id')->on('entitySubClass');
            $table->integer('idTypeRif');
            $table->foreign('idTypeRif')->references('id')->on('entitySubClass');
            $table->string('rif');
            $table->string('bankAccount');
            $table->string('holder')->nullable();
            $table->string('ciHolder')->nullable();
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
        Schema::dropIfExists('bankResidential');
    }
}
