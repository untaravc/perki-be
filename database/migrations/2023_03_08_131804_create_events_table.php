<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');
            $table->string('section');
            $table->string('marker')->nullable();
            $table->string('data_type');
            $table->integer('parent_id')->default(0);
            $table->string('slug');

            $table->string('name');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->string('place')->nullable();
            $table->string('place_link')->nullable();
            $table->string('link')->nullable();

            $table->string('speaker_ids')->nullable();
            $table->string('speakers')->nullable();
            $table->string('moderator_ids')->nullable();
            $table->string('moderators')->nullable();
            $table->string('panel_ids')->nullable();
            $table->string('panels')->nullable();

            $table->string('certificate')->nullable();
            $table->string('record_link')->nullable();
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_end')->nullable();
            $table->boolean('has_price')->default(0);
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
        Schema::dropIfExists('events');
    }
}
