<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class UpdateRolePermissionsCommand
{
    /**
     * @var array
     */
    public $permissions;

    /**
     * @var Role
     */
    public $role;

    /**
     * @param Role $role
     * @param array $permissions
     */
    public function __construct(Role $role, array $permissions)
    {
        $this->permissions = $permissions;
        $this->role = $role;
    }
}
