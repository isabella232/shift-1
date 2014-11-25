<?php
namespace Tectonic\Shift\Modules\Users\Events;

use Tectonic\Application\Eventing\Event;

class UserHasRegistered extends Event
{
    /**
     * @var User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
