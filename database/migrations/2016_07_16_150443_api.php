<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Api extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_key', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('key', 255)->index();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('api_log', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('api_key_id')->unsigned();
            $table->text('url');
            $table->text('request');
            $table->text('response');
            $table->timestamps();
            $table->foreign('api_key_id')->references('id')->on('api_key');
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
