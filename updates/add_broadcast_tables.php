<?php namespace Cleanse\Broadcast\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddBroadcastTables extends Migration
{
    public function up()
    {
        Schema::create('cleanse_broadcast_events', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('information')->nullable();
            $table->integer('active_match')->nullable();
            $table->integer('completed')->unsigned()->nullable();
            $table->string('source');
            $table->timestamp('event_datetime')->nullable();
            $table->timestamps();
        });

        Schema::create('cleanse_broadcast_matches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('match_id')->nullable();
            $table->integer('claws_team_id')->unsigned();
            $table->integer('fangs_team_id')->unsigned();
            $table->integer('claws_score')->unsigned()->nullable();
            $table->integer('fangs_score')->unsigned()->nullable();
            $table->integer('winner_id')->unsigned()->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cleanse_broadcast_matches');
        Schema::dropIfExists('cleanse_broadcast_events');
    }
}
