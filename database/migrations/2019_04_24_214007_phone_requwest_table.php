<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhoneRequwestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('phone_requwest', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('who_id')->unsigned()->index();
            $table->integer('target_id')->unsigned()->index();
            $table->boolean('readed')->default(0);
            $table->string('status',10)->nullable()->default(null);
            $table->string('who_name', 50)->nullable()->default(null);
            $table->string('image', 50)->nullable()->default(null);
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
        Schema::dropIfExists('phone_requwest');
    }
}
