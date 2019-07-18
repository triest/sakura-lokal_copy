<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeyGirlPhoneSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_settings', function (Blueprint $table) {
            $table->integer('id')->unsigned()->index();
            $table->string('name', 255)->nullable();
        });
        //
        Schema::table('girls', function (Blueprint $table) {
            //
            $table->foreign('phone_settings')->references('id')
                ->on('phone_settings');
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
            $table->dropForeign('phone_settings');
        });
    }
}
