<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginLeysToWhoneRequwestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phone_requwest', function (Blueprint $table) {
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
        Schema::table('whone_requwest', function (Blueprint $table) {
            //
            $table->dropForeign('who_id')->references('id')->on('users');
            $table->foreign('target_id')->references('id')->on('users');
        });
    }
}
