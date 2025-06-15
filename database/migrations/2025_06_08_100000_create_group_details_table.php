<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_details', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->integer('group_id');
            $table->integer('user_id')->nullable();
            $table->string('user_name');
            $table->string('institution')->nullable();
            $table->string('document_link')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('flag')->nullable();
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
        Schema::dropIfExists('group_details');
    }
}
