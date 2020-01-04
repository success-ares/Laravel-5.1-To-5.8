<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('phone', 20)->nullable();
            $table->string('company')->nullable();
            $table->string('company_url')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('business')->default(0);
            $table->string('activation_code', 50)->nullable();
            $table->boolean('status')->default(0);
            $table->string('password', 60);
            $table->decimal('balance', 8, 2)->default(0);
            $table->enum('type', ['admin', 'user'])->default('user');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
