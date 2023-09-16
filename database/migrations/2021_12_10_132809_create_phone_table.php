<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTypeEntity');
            $table->foreign('idTypeEntity')->references('id')->on('entitySubClass');
            $table->integer('idEntity');
            $table->integer('idTypePhone');
            $table->foreign('idTypePhone')->references('id')->on('entitySubClass');
            $table->integer('idAreaCode');
            $table->foreign('idAreaCode')->references('id')->on('entitySubClass');
            $table->string('number');
            $table->timestamps();
        });
        // $table->increments('id');
        // $table->integer('idUser');
        // $table->foreign('idUser')->references('id')->on('user');
        // $table->string('phone')->nullable();
        // $table->string('localphone');
        // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone');
    }
}
