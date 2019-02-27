<?php

namespace Cleanse\Broadcast\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddBroadcastCustomEventsTables extends Migration
{
    public function up()
    {
        Schema::create('cleanse_broadcast_teams', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('event_id')->nullable();
            $table->string('name');
            $table->string('initials')->nullable();
            $table->integer('points')->default(0);
            $table->timestamps();
        });

        Schema::create('cleanse_broadcast_players', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_id')->nullable();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cleanse_broadcast_players');
        Schema::dropIfExists('cleanse_broadcast_teams');
    }
}
