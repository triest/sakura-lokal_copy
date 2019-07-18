<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191)->nullable();
            $table->timestamps();
        });

        Schema::table('girls', function (Blueprint $table) {
            //
            $table->bigInteger('children_id')->unsigned()->index()->nullable()->default(null);
        });

        Schema::table('girls', function (Blueprint $table) {
            $table->foreign('children_id')->references('id')->on('children');
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
            $table->foreign('children_id');
        });

        Schema::dropIfExists('children');

        Schema::table('girls', function (Blueprint $table) {
            $table->dropColumn('children_id');
        });
    }
}
