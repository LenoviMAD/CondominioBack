<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planInvoice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUser')->nullable();
            $table->foreign('idUser')->references('id')->on('user');
            $table->integer('idPlan');
            $table->foreign('idPlan')->references('id')->on('plan');
            $table->date('paymentDate');
            $table->decimal('amount', 10, 2);
            $table->integer('idTime');
            $table->foreign('idTime')->references('id')->on('entitySubClass');
            $table->integer('idBank');
            $table->foreign('idBank')->references('id')->on('entitySubClass');
            $table->string('referenceNumber');
            $table->string('pathArchive')->nullable();
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
        Schema::dropIfExists('planInvoice');
    }
}
