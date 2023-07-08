<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_authors', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->tinyInteger('status');
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->string('institution')->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_presenter')->default(false);
            $table->boolean('is_corresponding')->default(false);
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('post_authors');
    }
}
