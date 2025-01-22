<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('section')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('category')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->text('body')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
