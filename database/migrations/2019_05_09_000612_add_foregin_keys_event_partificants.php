<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysEventPartificants extends Migration
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

            $table->foreign('participant_id')->references('id')->on('girls');
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

            $table->dropForeign('participant_id');
        });
    }
}
