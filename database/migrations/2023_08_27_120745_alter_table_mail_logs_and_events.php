<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMailLogsAndEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_logs', function ($table) {
            $table->text('content')->nullable()->after('sent_at');
        });

        Schema::table('events', function ($table) {
            $table->integer('certificate_space_top')->nullable()->after('certificate');
            $table->integer('certificate_space_left')->nullable()->after('certificate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_logs', function ($table) {
            $table->dropColumn([
                'content',
            ]);
        });

        Schema::table('events', function ($table) {
            $table->dropColumn([
                'certificate_space_top',
                'certificate_space_left',
            ]);
        });
    }
}
