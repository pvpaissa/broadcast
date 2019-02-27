<?php

namespace Cleanse\Broadcast\Models;

use Model;

/**
 * @property integer id
 * @property string  name
 * @property string  initials
 * @property integer points
 */
class Team extends Model
{
    public $table = 'cleanse_broadcast_teams';

    public $belongsTo = [
        'event' => [
            'Cleanse\Broadcast\Models\Event',
            'key' => 'event_id'
        ]
    ];
}
