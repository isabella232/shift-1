<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Events;

use Tectonic\Application\Eventing\Event;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class RoleWasCreated extends Event
{
    /**
     * @var Role
     */
    private $role;

    /**
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}
