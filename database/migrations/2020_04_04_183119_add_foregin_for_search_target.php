<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginForSearchTarget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('search_target', function (Blueprint $table) {
            $table->foreign('search_id')->references('id')
                ->on('seach_settings');
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
        Schema::table('search_target', function (Blueprint $table) {
            $table->dropForeign("search_id");
            $table->dropForeign("target_id");
        });
    }
}
