<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Report extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('reports', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('marker_id')->index();
            $table->timestamps();
        });

        Schema::table('markers', function(Blueprint $table) {

            $table->integer('number')->index()->change();
            $table->string('ip')->index()->change();
            $table->float('lat')->change();
            $table->float('lng')->change();
        });

        Schema::table('pokemons', function(Blueprint $table) {

            $table->integer('number')->index()->change();
            $table->string('name')->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reports');
    }
}
