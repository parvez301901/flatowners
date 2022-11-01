<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_models', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->integer('floorId')->nullable();
            $table->integer('unitId')->nullable();
            $table->integer('utilityId')->nullable();
            $table->integer('userId')->nullable();
            $table->date('maintenanceCostDate')->nullable();
            $table->string('maintenanceNote')->nullable();
            $table->string('maintenanceImage')->nullable();
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
        Schema::dropIfExists('maintenance_models');
    }
}
