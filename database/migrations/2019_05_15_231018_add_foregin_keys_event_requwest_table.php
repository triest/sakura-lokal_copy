<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysEventRequwestTable extends Migration
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
            $table->foreign('event_id')->references('id')->on('myevents');
            $table->foreign('girl_id')->references('id')->on('girls');
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
            //
            $table->dropForeign('event_id');
            $table->dropForeign('girl_id');
        });
    }
}
