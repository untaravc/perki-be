<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->boolean('user_is_speaker')->default(0);
            $table->string('user_name');
            $table->string('user_email')->unique();
            $table->timestamp('user_email_verified_at')->nullable();
            $table->string('user_password');
            $table->string('user_phone')->nullable();
            $table->string('user_institution')->nullable();
            $table->string('user_city')->nullable();
            $table->string('user_province')->nullable();
            $table->string('user_job_type')->nullable();
            $table->string('user_image')->nullable();
            $table->string('user_desc')->nullable();
            $table->string('user_forgot_password_token')->nullable();
            $table->string('user_otp')->nullable();
            $table->mediumInteger('user_status');
            $table->rememberToken();
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
}
