<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGlOnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function ($table) {
            $table->string('gl_name')->nullable()->after('plataran_img');
            $table->string('gl_photo')->nullable()->after('plataran_img');
            $table->string('transfer_proof_gl')->nullable()->after('plataran_img');
            $table->date('gl_date')->nullable()->after('plataran_img');
            $table->boolean('gl_status')->nullable()->after('plataran_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function ($table) {
            $table->dropColumn([
                'gl_name',
                'gl_photo',
                'gl_date',
                'gl_status',
                'transfer_proof_gl',
            ]);
        });
    }
}
