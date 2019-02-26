<?php

namespace Cleanse\Broadcast;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Cleanse Broadcast',
            'description' => 'Dynamic stream overlays to .',
            'author' => 'Paul Eli Lovato',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            //Overlays
            'Cleanse\Broadcast\Components\EventScore'           => 'cleanseBroadcastEventScore',
            'Cleanse\Broadcast\Components\EventSchedule'        => 'cleanseBroadcastEventSchedule',
            'Cleanse\Broadcast\Components\LeagueStandings'      => 'cleanseBroadcastLeagueStandings',
            'Cleanse\Broadcast\Components\LeagueBracket'        => 'cleanseBroadcastLeagueBracket',
            'Cleanse\Broadcast\Components\LeagueTourneyScore'   => 'cleanseBroadcastLeagueTourneyScore',

            //Panel
            'Cleanse\Broadcast\Components\Panel'            => 'cleanseBroadcastPanel',
            'Cleanse\Broadcast\Components\PanelEventCreate' => 'cleanseBroadcastPanelEventCreate',
            'Cleanse\Broadcast\Components\PanelEventEdit'   => 'cleanseBroadcastPanelEventEdit',
            'Cleanse\Broadcast\Components\PanelEventList'   => 'cleanseBroadcastPanelEventList',
            'Cleanse\Broadcast\Components\PanelEvent'       => 'cleanseBroadcastPanelEvent',
            'Cleanse\Broadcast\Components\PanelOverlays'    => 'cleanseBroadcastPanelOverlays'
            
            # Remove?
            //'Cleanse\Broadcast\Components\EventSummary'       => 'cleanseBroadcastEventSummary',
            //'Cleanse\Broadcast\Components\EventNext'          => 'cleanseBroadcastEventNext',
            //'Cleanse\Broadcast\Components\EventTimers'        => 'cleanseBroadcastEventTimers',
        ];
    }
}
