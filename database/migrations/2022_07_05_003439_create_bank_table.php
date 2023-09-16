<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTypeEntity');
            $table->foreign('idTypeEntity')->references('id')->on('entitySubClass');
            $table->integer('idEntity');
            $table->integer('idBank');
            $table->foreign('idBank')->references('id')->on('entitySubClass');
            $table->string('bankAccount');
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
        Schema::dropIfExists('bank');
    }
}
