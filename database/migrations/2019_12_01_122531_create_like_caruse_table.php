<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeCaruseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_caruse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('who_id')->unsigned()->index();
            $table->integer('target_id')->unsigned()->index();
            $table->boolean('view')->default(0);
            $table->boolean('like')->default(0);
            $table->dateTime('view_date')->default(now())->nullable();
            $table->dateTime('like_date')->default(null)->nullable();
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
        Schema::dropIfExists('like_caruse');
    }
}
