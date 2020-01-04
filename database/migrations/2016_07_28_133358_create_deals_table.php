<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referral_id')->unsigned();
            $table->integer('payment_id')->index();
            $table->string('payment_type');
            $table->decimal('amount', 8, 2);
            $table->enum('paid_status', ['Pending', 'Paid', 'Attention'])->default('Pending');
            $table->timestamps();
            $table->foreign('referral_id')->references('id')->on('referrals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deals');
    }
}
