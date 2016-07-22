<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IpLockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_lock', function(Blueprint $table) {

            $table->increments('id');
            $table->string('ip');
            $table->dateTime('end');
            $table->timestamps();
        });

        $ip = new \App\IpLock();
        $ip->ip =  '109.76.249.57';
        $ip->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ip_lock');
    }
}
