<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('girls', function (Blueprint $table) {
            //
            $table->integer('target_id')->nullable()->unsigned();
        });


        Schema::table('girls', function (Blueprint $table) {
            //
            $table->foreign('target_id')->references('id')->on('target');
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
        Schema::table('girls', function (Blueprint $table) {
            //

            $table->dropForeign('target_id');

        });
    }
}
