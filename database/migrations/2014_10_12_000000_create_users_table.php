<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('usertype')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();

            $table->string('presentaddress')->nullable();
            $table->string('permanentaddress')->nullable();
            $table->string('nid')->nullable();
            $table->string('email_nofication')->nullable();
            $table->string('sms_nofication')->nullable();
            $table->string('phone_nofication')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('floor')->nullable();
            $table->string('unit')->nullable();

            $table->string('salary')->nullable();
            $table->string('status')->nullable();
            $table->string('join_date')->nullable();
            $table->string('resignation_date')->nullable();

            $table->rememberToken();
            $table->text('profile_photo_path', 2048)->nullable();
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
        Schema::dropIfExists('users');
    }
};
