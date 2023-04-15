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
            $table->boolean('is_speaker')->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('institution')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('job_type_code')->nullable();
            $table->string('image')->nullable();
            $table->string('desc')->nullable();
            $table->string('forgot_password_token')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('otp')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->mediumInteger('status')->default(100);
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
