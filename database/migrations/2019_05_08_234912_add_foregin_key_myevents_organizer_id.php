<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyMyeventsOrganizerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('myevents', function (Blueprint $table) {
            //
            $table->foreign('organizer_id')->references('id')->on('girls');
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
        Schema::table('myevents', function (Blueprint $table) {
            $table->dropForeign('organizer_id');
        });
    }
}
