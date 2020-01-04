<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_debits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id')->unsigned();
            $table->string('account_number');
            $table->string('account_name');
            $table->string('bank_name');
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');
            $table->timestamps();
            $table->foreign('billing_id')->references('id')->on('billings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('direct_debits');
    }
}
