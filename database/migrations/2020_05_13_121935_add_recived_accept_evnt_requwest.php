<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddRecivedAcceptEvntRequwest extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::table('event_requwest', function (Blueprint $table) {
                //
                $table->boolean('read_accept_notification')->nullable()
                        ->default(false);
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
            Schema::table('event_requwest', function (Blueprint $table) {
                //
                $table->dropColumn('read_accept_notification');
            });
        }
    }
