<?php
namespace Tectonic\Shift\Modules\Users\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Users\Models\User;

class AdminUserWasCreated extends Event
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
 