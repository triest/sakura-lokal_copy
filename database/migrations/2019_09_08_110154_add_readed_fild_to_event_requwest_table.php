<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReadedFildToEventRequwestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_requwest', function (Blueprint $table) {
            //
            $table->boolean('alert_notification_today_received')->nullable()
                ->default(false);
            $table->boolean('alert_notification_tomorow_received')->nullable()
                ->default(false);
            $table->boolean('email_notification_today_received')->nullable()
                ->default(false);
            $table->boolean('email_notification_tomorow_received')->nullable()
                ->default(false);
            $table->boolean('sms_notification_today_received')->nullable()
                ->default(false);
            $table->boolean('sms_notification_tomorow_received')->nullable()
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_requwest', function (Blueprint $table) {
            $table->dropColumn('alert_notification_today_received');
            $table->dropColumn('alert_notification_tomorow_received');
            $table->dropColumn('email_notification_today_received');
            $table->dropColumn('email_notification_tomorow_received');
            $table->dropColumn('sms_notification_today_received');
            $table->dropColumn('sms_notification_tomorow_received');
            //
        });
    }
}
