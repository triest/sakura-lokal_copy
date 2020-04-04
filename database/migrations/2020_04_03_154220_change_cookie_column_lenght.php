<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCookieColumnLenght extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('seach_settings', function (Blueprint $table) {
            //
            $table->string('cookie', 1000)->nullable()->default(null)->change();
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
        //
        Schema::table('seach_settings', function (Blueprint $table) {
            //
            $table->string('cookie', 100)->nullable()->default(null)->change();
        });


    }
}
