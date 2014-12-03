<?php
namespace Tectonic\Shift\Modules\Identity\Users\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

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
 