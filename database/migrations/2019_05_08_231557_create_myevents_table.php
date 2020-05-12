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
                $table->string('name', 191)->default(null)->nullable();
                $table->string('place', 191)->default(null)->nullable();
                $table->text('description');
                $table->dateTime('begin')->nullable()->default(null);
                $table->dateTime('end')->nullable()->default(null);
                $table->dateTime('end_applications')->nullable()->default(null);
                $table->integer('max_people')->nullable()->default(null);
                $table->integer('min_people')->nullable()->default(null);
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
