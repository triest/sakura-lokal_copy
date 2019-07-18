<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmokingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smoking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191)->nullable();
            $table->timestamps();
        });

        Schema::table('girls', function (Blueprint $table) {
            //
            $table->bigInteger('smoking_id')->unsigned()->index()->nullable()->default(null);
        });

        Schema::table('girls', function (Blueprint $table) {
            $table->foreign('smoking_id')->references('id')->on('smoking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smoking');
    }
}
