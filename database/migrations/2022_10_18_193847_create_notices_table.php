<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('noticeTitle');
            $table->string('noticeDescription')->nullable();
            $table->string('email_notification')->nullable();
            $table->string('sms_notification')->nullable();
            $table->string('dashboard_notification')->nullable();
            $table->string('notice_to')->nullable();
            $table->string('notice_for')->nullable();
            $table->string('notice_status')->nullable();
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
        Schema::dropIfExists('notices');
    }
}
