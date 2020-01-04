<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypesFieldsToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notification_image')->nullable()->after('notification_status');
            $table->string('notification_icon_style')->nullable()->after('notification_status');
            $table->string('notification_icon')->nullable()->after('notification_status');
            $table->string('notification_link')->nullable()->after('notification_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['notification_image', 'notification_icon_style', 'notification_icon', 'notification_link']);
        });
    }
}
