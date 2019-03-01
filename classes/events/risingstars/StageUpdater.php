<?php

namespace Cleanse\Broadcast\Classes\Events\RisingStars;

use Cleanse\Broadcast\Classes\Events\RisingStars\StageFormat;
use Cleanse\Broadcast\Models\Match;

/**
 * Class StageUpdater
 * @package Cleanse\Broadcast\Classes\Events\RisingStars
 */
class StageUpdater
{
    public function updateMatch($matchId)
    {
        $match = Match::find($matchId);

        $match->claws_score = post('claws_score');
        $match->fangs_score = post('fangs_score');

        $match->save();
    }

    public function completeMatch($matchId)
    {
        $match = Match::find($matchId);

        if ($match->claws_score > $match->fangs_score) {
            $match->winner_id = $match->claws_team_id;
            $match->save();
        } elseif ($match->fangs_score > $match->claws_score) {
            $match->winner_id = $match->fangs_team_id;
            $match->save();
        } else {
            return false;
        }

        $format = new StageFormat($matchId);
        $success = $format->getNextRound();

        return $success;
    }

    //off?
    public function unlockMatch($matchId)
    {
        $match = Match::find($matchId);

        $match->winner_id = null;
        $match->save();
    }
}
