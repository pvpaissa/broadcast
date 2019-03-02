<?php

namespace Cleanse\Broadcast\Components;

use Cms\Classes\ComponentBase;

use Cleanse\Broadcast\Models\Event;
use Cleanse\Broadcast\Models\Match;

class RisingStarsScore extends ComponentBase
{
    public $standings;

    public function componentDetails()
    {
        return [
            'name'        => 'Broadcast Rising Stars Score',
            'description' => 'Display the Rising Stars tourney score.',
        ];
    }

    public function onRun()
    {
        $this->addCss('assets/css/bootstrap.min.css');
        $this->addCss('assets/css/rising-stars.css');
        $this->addJs('assets/js/jquery.min.js');
        $this->addJs('assets/js/rising.js');

        $this->page['match'] = $this->getRisingScore();
    }

    private function getRisingScore()
    {
        $activeMatch = $this->getActiveMatch();

        if (!isset($activeMatch)) {
            return false;
        }

        return $this->getMatch($activeMatch);
    }

    /**
     * @return mixed
     */
    private function getActiveMatch()
    {
        return Event::orderBy('id', 'desc')
            ->first()->active_match;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getMatch($id)
    {
        $match = Match::with(['claws', 'fangs'])
            ->where([
                'id' => $id
            ])
            ->first();
        
        return $match;
    }
}
