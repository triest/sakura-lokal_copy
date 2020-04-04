<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginForSearchInterest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('search_interest', function (Blueprint $table) {
            $table->foreign('search_id')->references('id')
                ->on('seach_settings');
            $table->foreign('interest_id')->references('id')->on('interests');
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
        Schema::table('search_interest', function (Blueprint $table) {
            $table->dropForeign("search_id");
            $table->dropForeign("interest_id");
        });
    }
}
