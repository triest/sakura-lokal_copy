<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReadedValueToPresent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gift_act', function (Blueprint $table) {
            $table->dateTime('begin_search')->nullable();
            $table->dateTime('end_search')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('present', function (Blueprint $table) {
            //
            Schema::table('gift_act', function (Blueprint $table) {
                $table->dropColumn('begin_search');
                $table->dropColumn('end_search');
            });
        });
    }
}
