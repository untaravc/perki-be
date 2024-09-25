<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikAndDeactive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('transactions', function ($table) {
        //     $table->string('user_nik')->nullable()->after('user_email');
        // });

        Schema::table('contacts', function ($table) {
            $table->boolean('is_block')->nullable()->after('bc_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('transactions', function ($table) {
        //     $table->dropColumn([
        //         'user_nik'
        //     ]);
        // });

        Schema::table('contacts', function ($table) {
            $table->dropColumn([
                'is_block'
            ]);
        });
    }
}
