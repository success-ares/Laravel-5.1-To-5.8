<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('biz_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->boolean('public')->default(0);
            $table->decimal('amount', 8, 2);
            $table->enum('measure', ['%', '$']);
            $table->decimal('lead_reward', 8, 2)->nullable();
            $table->boolean('auto_approve')->default(0);
            $table->timestamps();
            $table->foreign('biz_id')->references('id')->on('biz')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
