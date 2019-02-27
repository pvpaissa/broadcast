<?php namespace Cleanse\Broadcast\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddBroadcastCasterTables extends Migration
{
    public function up()
    {
        Schema::create('cleanse_broadcast_casters', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('names');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cleanse_broadcast_casters');
    }
}
