<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Seen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sights', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('marker_id')->index();
            $table->timestamps();
        });

        Schema::table('markers', function(Blueprint $table) {

            $table->integer('sights');
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
    }
}
