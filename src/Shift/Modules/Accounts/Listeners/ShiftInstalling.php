<?php
namespace Tectonic\Shift\Modules\Accounts\Listeners;

use Tectonic\Shift\Library\Support\Listener;

class ShiftInstalling extends Listener
{
    /**
     * Returns an array containing the events the listener will hook into. The key is the event,
     * and the value is the event handler method on the class.
     *
     * @returns array
     */
    public function hooks()
    {
        return [
            'shift.installing' => 'createAccount'
        ];
    }

    public function createAccount(array $input)
    {

    }
}
 