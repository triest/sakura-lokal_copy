<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginViewViewSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('view_history', function (Blueprint $table) {
            //
            $table->foreign('source_id')->references('id')->on('view_source');

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
        Schema::table('view_history', function (Blueprint $table) {
            //
            $table->dropForeign('source_id');
        });
    }
}
