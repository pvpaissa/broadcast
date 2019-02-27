<?php

namespace Cleanse\Broadcast\Models;

use Model;

/**
 * @property integer $id
 * @property string $name
 * @property string initials
 */
class Team extends Model
{
    public $table = 'cleanse_broadcast_teams';
}
