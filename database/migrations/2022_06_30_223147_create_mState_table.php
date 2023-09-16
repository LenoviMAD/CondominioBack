<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mState', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('idCountry')->nullable();
            $table->foreign('idCountry')->references('id')->on('mCountry');
            $table->string('iso');
            $table->string('name');
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
        Schema::dropIfExists('mState');
    }
}
