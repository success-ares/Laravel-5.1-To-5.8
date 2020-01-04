<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referral_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->text('message');
            $table->string('file_name')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('read')->default(0);
            $table->timestamps();
            $table->foreign('referral_id')->references('id')->on('referrals');
            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
