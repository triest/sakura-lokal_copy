<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyGirlGirlInteressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('girl_interess', function (Blueprint $table) {
            $table->foreign('girl_id')->references('id')->on('girls');
            $table->foreign('interest_id')->references('id')->on('interests');
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
        Schema::table('girl_interess', function (Blueprint $table) {
            $table->dropForeign("girl_id");
            $table->dropForeign("interes_id");
        });
    }
}
