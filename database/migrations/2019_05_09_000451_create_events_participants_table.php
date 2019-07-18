<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id')->unsigned()->index();
            $table->integer('participant_id')->unsigned()->index();
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
        Schema::create('events_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id')->unsigned()->index();
            $table->integer('participant_id')->unsigned()->index();
            $table->timestamps();
        });
    }
}
