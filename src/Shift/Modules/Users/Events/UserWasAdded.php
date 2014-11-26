<?php
namespace Tectonic\Shift\Modules\Users\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Users\Models\User;

class UserWasAdded extends Event
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
