<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyeventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myevents', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('organizer_id')->unsigned()->index();
            $table->string('name', 191)->nullable();
            $table->string('place', 191)->nullable();
            $table->text('description');
            $table->dateTime('begin')->default(null);
            $table->dateTime('end')->default(null);
            $table->dateTime('end_applications')->default(null);
            $table->integer('max_people');
            $table->integer('min_people');
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
        Schema::dropIfExists('myevents');
    }
}
