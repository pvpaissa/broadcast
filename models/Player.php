<?php

namespace Cleanse\Broadcast\Models;

use Model;

/**
 * @property integer id
 * @property integer team_id
 * @property string  name
 */
class Player extends Model
{
    public $table = 'cleanse_broadcast_players';
}
