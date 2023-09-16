<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdentityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idTypeEntity');
            $table->foreign('idTypeEntity')->references('id')->on('entitySubClass');
            $table->integer('idEntity');
            $table->integer('idTypeIdentity');
            $table->foreign('idTypeIdentity')->references('id')->on('entitySubClass');
            $table->integer('idTypeDocument');
            $table->foreign('idTypeDocument')->references('id')->on('entitySubClass');
            $table->string('number')->unique();
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
        Schema::dropIfExists('identity');
    }
}
