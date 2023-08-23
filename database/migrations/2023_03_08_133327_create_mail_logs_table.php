<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email_sender');
            $table->string('email_receiver');
            $table->string('receiver_name')->nullable();
            $table->string('label')->nullable();
            $table->string('category')->nullable();
            $table->string('title')->nullable();
            $table->string('model')->nullable();
            $table->integer('model_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->text('log')->nullable();
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
        Schema::dropIfExists('mail_logs');
    }
}
