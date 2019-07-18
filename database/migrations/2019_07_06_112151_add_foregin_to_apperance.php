<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginToApperance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('girls', function (Blueprint $table) {
            //
            $table->bigInteger('apperance_id')->nullable()->unsigned()->index();
        });


        Schema::table('girls', function (Blueprint $table) {
            $table->foreign('apperance_id')->references('id')->on('appearance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('girls', function (Blueprint $table) {
            $table->dropColumn('apperance_id');
        });

        Schema::table('girls', function (Blueprint $table) {
            $table->dropForeign('apperance_id');
        });
    }
}
