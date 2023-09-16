<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaulterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defaulter', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idResidential')->unique();
            $table->foreign('idResidential')->references('id')->on('residential');
            $table->string('certificate');
            $table->integer('penaltyPercent');
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
        Schema::dropIfExists('defaulter');
    }
}
