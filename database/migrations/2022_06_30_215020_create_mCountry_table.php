<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mCountry', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('iso2');
            $table->string('iso3');
            $table->string('name');
            $table->string('ison');
            $table->string('internationalPhoneCode')->nullable();
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
        Schema::dropIfExists('mCountry');
    }
}
