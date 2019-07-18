<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysEventPartificants2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('events_participants', function (Blueprint $table) {
            //
            // $table->foreign('event_id')->references('id')->on('myevents');
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
        Schema::table('events_participants', function (Blueprint $table) {
            //
            $table->dropForeign('event_id');
        });
    }
}
