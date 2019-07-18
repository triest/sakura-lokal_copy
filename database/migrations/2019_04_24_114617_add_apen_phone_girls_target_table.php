<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApenPhoneGirlsTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('girl_open_phone_girl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('girl_id')->unsigned()->index();
            $table->integer('target_id')->unsigned()->index();
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
        Schema::dropIfExists('girl_open_phone_girl');
    }
}
