<?php

namespace Tectonic\Shift\Library\Support;

abstract class Listener
{
    /**
     * Loop through the registered hooks for the class and register them
     * with the events library in Laravel.
     *
     * @param $events
     */
    public function subscribe($events)
    {
        foreach ($this->hooks() as $event => $handler) {
            $events->listen($event, static::class . '@' . $handler);
        }
    }

    /**
     * Returns an array containing the events the listener will hook into. The key is the event,
     * and the value is the event handler method on the class.
     *
     * @returns array
     */
    abstract public function hooks();
}
