<?php

namespace Cleanse\Broadcast\Models;

use Model;

/**
 * @property integer id
 * @property string  name
 * @property string  information
 * @property integer completed
 * @property string  source
 * @property string  event_datetime
 */
class Event extends Model
{
    public $table = 'cleanse_broadcast_events';

    /**
     * Relationships
     */
    public $hasMany = [
        'matches' => [
            'Cleanse\Broadcast\Models\Match',
            'key' => 'event_id',
            'otherKey' => 'id'
        ],
        'teams' => [
            'Cleanse\Broadcast\Models\Team',
            'key' => 'event_id',
            'otherKey' => 'id'
        ]
    ];
}
