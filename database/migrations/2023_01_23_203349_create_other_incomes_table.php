<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('other_incomes', function (Blueprint $table) {
            $table->id();
            $table->date('other_income_month_year')->nullable();
            $table->integer('other_income_amount')->nullable();
            $table->string('other_income_detail')->nullable();
            $table->date('other_income_date')->nullable();
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
        Schema::dropIfExists('other_incomes');
    }
}
