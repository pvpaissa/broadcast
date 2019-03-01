<?php

namespace Cleanse\Broadcast\Components;

use Redirect;
use Cms\Classes\ComponentBase;

use Cleanse\Broadcast\Classes\Events\RisingStars\StageUpdater;
use Cleanse\Broadcast\Models\Event;
use Cleanse\Broadcast\Models\Match;
use Cleanse\Broadcast\Models\Caster as BroadcastCasters;

class PanelRisingStars extends ComponentBase
{
    public $id;

    public function componentDetails()
    {
        return [
            'name'        => 'Broadcast Rising Stars Panel',
            'description' => 'Update the Rising Stars event.',
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title'       => 'Event ID',
                'description' => 'Event identification channel.',
                'default'     => '{{ :id }}',
                'type'        => 'string',
            ]
        ];
    }

    public function onRun()
    {
        $this->addCss('assets/css/rising-stars.css');

        $this->id = $this->property('id');
        $this->page['event'] = $this->getEvent();
        $this->page['casters'] = $this->getCasters();
    }

    private function getEvent()
    {
        $event = Event::whereId($this->id)
            ->with(['matches' => function ($query) {
                $query->orderBy('order', 'asc');
                $query->with(['claws', 'fangs']);
            }])
            ->first();

        return $event;
    }

    /**
     * Updating Scores and Active Match (because of scoreboard, 
     * we want to manually control the active match).
     */
    public function onUpdateScore()
    {
        $update = new StageUpdater();
        $update->updateMatch(post('matchId'));

        return Redirect::to('/broadcast/panel/rising-stars/' . post('eventId') . '#' . post('matchId'));
    }

    public function onSetActiveMatch()
    {
        $event = Event::whereId(post('eventId'))->first();
        $event->active_match = post('matchId');
        $event->save();

        return Redirect::to('/broadcast/panel/rising-stars/' . post('eventId') . '#' . post('matchId'));
    }

    /**
     * Re-order matches for current event.
     */
    public function onMatchOrder()
    {
        $matches = post('match');

        foreach($matches as $key => $value) {
            $match = Match::whereId($key)->first();
            $match->order = $value[0];

            $match->save();
        }

        return Redirect::back();
    }

    /**
     * Finalize Match
     */
    public function onCompleteMatch()
    {
        $update = new StageUpdater();
        $update->completeMatch(post('matchId'));
    }
    
    /**
     * Stream commentator/caster Form Methods.
     */
    public function onCasterUpdate()
    {
        $update = BroadcastCasters::find(1);
        $update->names = post('casters');
        $update->save();
    }

    private function getCasters()
    {
        return BroadcastCasters::find(1)->names;
    }
}
