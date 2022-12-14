<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_charges', function (Blueprint $table) {
            $table->id();
            $table->date('serviceChargeMonthYear')->nullable();
            $table->integer('serviceChargeAmount')->nullable();
            $table->integer('serviceChargeDue')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('floor_id')->nullable();
            $table->date('serviceChargeDate')->nullable();
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
        Schema::dropIfExists('service_charges');
    }
}
