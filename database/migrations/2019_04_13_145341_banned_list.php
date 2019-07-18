<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BannedList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('banned_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('girl_id')->unsigned()->index();
            $table->dateTime('baginBanned')->nullable();
            $table->string('cause',100)->nullable();
            $table->dateTime('endBanned')->nullable();
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
    }
}
