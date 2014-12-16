<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Events;

use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class RoleWasCreated
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
