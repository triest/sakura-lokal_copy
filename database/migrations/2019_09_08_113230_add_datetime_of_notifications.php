<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatetimeOfNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('event_requwest', function (Blueprint $table) {
            //
            $table->dateTime('alert_notification_today')->nullable()
                ->default(null);
            $table->dateTime('alert_notification_tomorow')->nullable()
                ->default(null);
            $table->dateTime('email_notification_today')->nullable()
                ->default(null);
            $table->dateTime('email_notification_tomorow')->nullable()
                ->default(null);
            $table->dateTime('sms_notification_today')->nullable()
                ->default(null);
            $table->dateTime('sms_notification_tomorow')->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('event_requwest', function (Blueprint $table) {
            $table->dropColumn('alert_notification_today');
            $table->dropColumn('alert_notification_tomorow');
            $table->dropColumn('email_notification_today');
            $table->dropColumn('email_notification_tomorow');
            $table->dropColumn('sms_notification_today');
            $table->dropColumn('sms_notification_tomorow');
            //
        });
    }
}
