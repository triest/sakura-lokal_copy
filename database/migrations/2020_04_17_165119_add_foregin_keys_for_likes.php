<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysForLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('likes', function (Blueprint $table) {
            //
            $table->foreign('who_id')->references('id')->on('girls');
            $table->foreign('target_id')->references('id')->on('girls');
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
        Schema::table('likes', function (Blueprint $table) {
            //
            $table->dropForeign('who_id');
            $table->dropForeign('target_id');
        });
    }
}
