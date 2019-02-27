<?php

namespace Cleanse\Broadcast\Models;

use Model;

/**
 * @property integer id
 * @property integer event_id
 * @property string  match_id
 * @property integer claws_team_id
 * @property integer fangs_team_id
 * @property integer claws_score
 * @property integer fangs_score
 * @property integer winner_id
 * @property integer active
 * @property integer order
 */
class Match extends Model
{
    public $table = 'cleanse_broadcast_matches';

    public $hasOne = [
        'claws' => [
            'Cleanse\Broadcast\Models\Team',
            'key' => 'id',
            'otherKey' => 'claws_team_id'
        ],
        'fangs' => [
            'Cleanse\Broadcast\Models\Team',
            'key' => 'id',
            'otherKey' => 'fangs_team_id'
        ]
    ];

    public $belongsTo = [
        'event' => [
            'Cleanse\Broadcast\Models\Event',
            'key' => 'event_id'
        ]
    ];
}
