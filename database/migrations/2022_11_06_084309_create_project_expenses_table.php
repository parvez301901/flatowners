<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('utility_id')->nullable();
            $table->date('project_cost_date')->nullable();
            $table->string('project_cost_note')->nullable();
            $table->string('project_cost_image')->nullable();
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
        Schema::dropIfExists('project_expenses');
    }
}
