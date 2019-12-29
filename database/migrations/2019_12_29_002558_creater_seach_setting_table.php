<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaterSeachSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('seach_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('girl_id')->nullable()->unsigned()->index();
            $table->string('target_array')->nullable()->index();
            $table->string('interest_array')->nullable()->index();
            $table->string('meet')->nullable();
            $table->integer('age_from')->nullable()->unsigned();
            $table->integer('age_to')->nullable()->unsigned();
            $table->integer('children')->unsigned()->nullable();
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
        Schema::dropIfExists('seach_settings');
    }
}
