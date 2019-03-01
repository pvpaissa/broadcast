<?php

namespace Cleanse\Broadcast\Classes\Events\RisingStars;

use Cleanse\Broadcast\Models\Team;
use October\Rain\Support\Collection;

use Cleanse\Broadcast\Models\Match;

class StageFormat
{
    private $match;

    public function __construct($matchId)
    {
        $this->match = Match::find($matchId);
    }

    public function getNextRound()
    {
        $teams = [
            $this->match->claws_team_id,
            $this->match->fangs_team_id
        ];

        foreach ($teams as $team) {
            if ($team == $this->match->winner_id) {
                $this->advanceWinner($team);
            }
        }

        return true;
    }

    private function advanceWinner($team)
    {
        switch ($this->match->order) {
            case 1:
                //Winner goes to Match 4 and 5 as Claws.
                $this->updateMatch($team, 4, 'claws');
                $this->updateMatch($team, 5, 'claws');
                $this->qualifyTeam($team);
                break;
            case 2:
                //Winner goes to Match 4 as Fangs and 6 as Claws.
                $this->updateMatch($team, 4, 'fangs');
                $this->updateMatch($team, 6, 'claws');
                $this->qualifyTeam($team);
                break;
            case 3:
                //Winner goes to Matches 5 and 6 as Fangs.
                $this->updateMatch($team, 5, 'fangs');
                $this->updateMatch($team, 6, 'fangs');
                $this->qualifyTeam($team);
                break;
            case 4:
                //Winner gains a point.
                $this->scorePoint($team);
                break;
            case 5:
                //Winner gains a point.
                $this->scorePoint($team);
                break;
            case 6:
                //Winner gains a point and we generate Finals.
                $this->scorePoint($team);
                $this->generateGrandFinals();
                break;
            case 7:
                //Winners flagged as the Champions.
                break;
        }
    }
    
    private function updateMatch($teamId, $match, $team)
    {
        $getMatch = Match::where('order', '=', $match)
            ->orderBy('event_id', 'desc')
            ->first();

        if ($team == 'claws') {
            $getMatch->claws_team_id = $teamId;
        } elseif ($team == 'fangs') {
            $getMatch->fangs_team_id = $teamId;
        }

        $getMatch->save();
    }

    private function qualifyTeam($team)
    {
        $team = Team::find($team);
        $team->qualified = 1;
        $team->save();
    }

    private function scorePoint($team)
    {
        $team = Team::find($team);
        $team->points = $team->points + 1;
        $team->save();
    }

    private function generateGrandFinals()
    {
        $teams = Team::where('qualified', '=', 1)
            ->orderBy('points', 'desc')
            ->take(2)
            ->get();

        $this->updateMatch($teams[0]->id, 7, 'claws');
        $this->updateMatch($teams[1]->id, 7, 'fangs');
    }
}
