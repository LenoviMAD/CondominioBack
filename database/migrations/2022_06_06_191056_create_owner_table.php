<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUser')->nullable();
            $table->foreign('idUser')->references('id')->on('user');
            $table->integer('idApartment');
            $table->foreign('idApartment')->references('id')->on('apartment');
            $table->string('document')->nullable();
            $table->boolean('credentials');
            $table->boolean('changePassword');
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
        Schema::dropIfExists('owner');
    }
}
