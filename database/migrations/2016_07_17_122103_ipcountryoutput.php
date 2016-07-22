<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ipcountryoutput extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('ip_countries', function(Blueprint $table) {

            $table->double('lat')->null()->default(0);
            $table->double('lng')->null()->default(0);
            $table->text('output');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ip_countries', function(Blueprint $table) {

            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('output');
        });
    }
}
