<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkToPrivatePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('private_photos', function (Blueprint $table) {
            //
            $table->foreign('girl_id')->references('id')->on('girls');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('private_photos', function (Blueprint $table) {
            //
            $table->dropForeign('girl_id');
        });
        */
    }
}
