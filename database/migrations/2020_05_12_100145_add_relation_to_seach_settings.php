<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddRelationToSeachSettings extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('seach_settings', function (Blueprint $table) {
                //
                $table->integer('relation')->nullable()
                        ->default(null);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('seach_settings', function (Blueprint $table) {
                //
                $table->dropColumn('relation');
            });
        }
    }
