<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCityPhoneCodeAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mCityPhoneCodeArea', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('idCity')->nullable();
            $table->foreign('idCity')->references('id')->on('mCity');
            $table->string('code');
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
        Schema::dropIfExists('mCityPhoneCodeArea');
    }
}
