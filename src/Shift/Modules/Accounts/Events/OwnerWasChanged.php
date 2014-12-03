<?php
namespace Tectonic\Shift\Modules\Accounts\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class OwnerWasChanged extends Event
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
