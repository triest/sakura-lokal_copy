<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForSeach extends Migration
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
            $table->dateTime('begin_search')->default(null)->nullable();
            $table->dateTime('end_search')->default(null)->nullable();
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
            $table->dropColumn('begin_search');
            $table->dropColumn('end_search');
        });
    }
}
