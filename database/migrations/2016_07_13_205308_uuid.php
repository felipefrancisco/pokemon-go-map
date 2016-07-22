<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('markers', function(Blueprint $table) {

            $table->string('uuid', 255);
            $table->dropColumn('json');
        });

        $markers = \App\Marker::all();

        foreach($markers as $marker) {

            $marker->uuid = \Ramsey\Uuid\Uuid::uuid4();
            $marker->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markers', function(Blueprint $table) {

            $table->dropColumn('uuid');
            $table->text('json');
        });
    }
}
