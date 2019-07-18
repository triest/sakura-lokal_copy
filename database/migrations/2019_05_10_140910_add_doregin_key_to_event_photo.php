<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDoreginKeyToEventPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_photos', function (Blueprint $table) {
            //
            $table->foreign('event_id')->references('id')->on('myevents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_photos', function (Blueprint $table) {
            //
            $table->dropForeign('event_id');
        });
    }
}
