<?php namespace Tectonic\Shift\Modules\Authentication\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class UserHasAuthenticated extends Event
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