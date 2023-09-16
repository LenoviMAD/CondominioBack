<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTower');
            $table->foreign('idTower')->references('id')->on('tower');
            $table->integer('idUser')->nullable();
            $table->foreign('idUser')->references('id')->on('user');
            $table->string('name');
            $table->string('floor');
            $table->string('apartment');
            $table->string('intercom');
            $table->string('parking');
            $table->decimal('aliquot', 4, 2);
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
        Schema::dropIfExists('apartment');
    }
}
