<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTowerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tower', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idResidential');
            $table->foreign('idResidential')->references('id')->on('residential');
            $table->string('name');
            $table->integer('nApartments');
            $table->integer('nApartmentsXFloor');
            $table->integer('nFloor');
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
        Schema::dropIfExists('tower');
    }
}
