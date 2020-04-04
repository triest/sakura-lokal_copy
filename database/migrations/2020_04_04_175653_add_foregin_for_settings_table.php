<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginForSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('settings_table', function (Blueprint $table) {
            $table->foreign('settings_id')->references('id')
                ->on('seach_settings');
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
        Schema::table('settings_table', function (Blueprint $table) {
            $table->dropForeign('settings_id');
        });
    }
}
