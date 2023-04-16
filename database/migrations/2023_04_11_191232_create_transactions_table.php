<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->string('number')->nullable();
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('user_phone')->nullable();
            $table->string('user_email')->nullable();
            $table->string('job_type_code');
            $table->integer('subtotal')->nullable();
            $table->string('voucher_code')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('service_fee')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('total')->nullable();
            $table->mediumInteger('status')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('transfer_proof')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
