<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->integer('user_id');
            $table->float('first_score')->nullable();
            $table->float('second_score')->nullable();
            $table->float('third_score')->nullable();
            $table->float('fourth_score')->nullable();
            $table->float('fifth_score')->nullable();
            $table->float('sixth_score')->nullable();
            $table->float('seventh_score')->nullable();
            $table->float('total')->nullable();
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
        Schema::dropIfExists('scores');
    }
}
