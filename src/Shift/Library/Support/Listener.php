<?php

namespace Tectonic\Shift\Library\Support;

class Listener
{
	public function hook($events, $event, $method)
    {
        $events->listen($event, static::class.'@'.$method);
    }
}
