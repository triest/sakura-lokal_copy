<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeachInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('settings_table', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('settings_id')->unsigned()->nullable()->index();
            $table->string('setting_name', 255)->nullable();
            $table->integer('sett_id')->unsigned()->nullable()->index();

            $table->timestamps();
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
        Schema::dropIfExists('settings_table');
    }
}
