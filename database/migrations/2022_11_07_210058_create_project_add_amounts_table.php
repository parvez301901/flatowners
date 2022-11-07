<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAddAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_add_amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->date('project_add_date')->nullable();
            $table->string('project_cost_note')->nullable();
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
        Schema::dropIfExists('project_add_amounts');
    }
}
