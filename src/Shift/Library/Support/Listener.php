<?php

namespace Tectonic\Shift\Library\Support;

class Listener
{
    /**
     * Hooks array. Registers an associative array where the key is the event,
     * and the value is the event handler on the class.
     *
     * @var array
     */
    protected $hooks = [];

    /**
     * Loop through the registered hooks for the class and register them
     * with the events library in Laravel.
     *
     * @param $events
     */
    public function subscribe($events)
    {
        foreach ($this->hooks as $event => $handler) {
            $events->listen($event, static::class . '@' . $handler);
        }
    }
}
