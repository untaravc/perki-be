<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOnEventUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_users', function ($table) {
            $table->string('user_email')->after('scanner_id');
            $table->string('user_name')->after('scanner_id');
            $table->integer('transaction_id')->after('scanner_id');
            $table->integer('transaction_detail_id')->after('scanner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_users', function ($table) {
            $table->dropColumn([
                'transaction_detail_id',
                'transaction_id',
                'user_name',
                'user_email',
            ]);
        });
    }
}
