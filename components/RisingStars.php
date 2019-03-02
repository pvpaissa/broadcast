<?php

namespace Cleanse\Broadcast\Components;

use Cms\Classes\ComponentBase;

class RisingStars extends ComponentBase
{
    public $standings;

    public function componentDetails()
    {
        return [
            'name'        => 'Broadcast Rising Stars Event Overlay',
            'description' => 'Display Rising Stars event progress.',
        ];
    }

    public function onRun()
    {
        $this->addCss('assets/css/bootstrap.min.css');
        $this->addCss('assets/css/rising-stars.css');
        $this->addJs('assets/js/jquery.min.js');
        $this->addJs('assets/js/rising.js');
    }
}
