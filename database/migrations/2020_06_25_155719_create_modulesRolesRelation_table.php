<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesRolesRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulesRolesRelation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idRole');
            $table->foreign('idRole')->references('id')->on('role');
            $table->integer('idModule');
            $table->foreign('idModule')->references('id')->on('module');
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
        Schema::dropIfExists('modulesRolesRelation');
    }
}
