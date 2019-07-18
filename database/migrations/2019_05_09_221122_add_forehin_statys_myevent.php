<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForehinStatysMyevent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('myevents', function (Blueprint $table) {//
            // $table->index('status_id')->references('id')->on('event_statys');
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
        Schema::table('myevents', function (Blueprint $table) {//
            $table->dropForeign('status_id');
        });
    }
}
