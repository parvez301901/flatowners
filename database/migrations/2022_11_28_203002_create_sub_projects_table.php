<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('sub_project_budget')->nullable();
            $table->string('sub_project_description')->nullable();
            $table->date('sub_project_start_date')->nullable();
            $table->date('sub_project_end_date')->nullable();
            $table->string('sub_project_status')->nullable();
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
        Schema::dropIfExists('sub_projects');
    }
}
