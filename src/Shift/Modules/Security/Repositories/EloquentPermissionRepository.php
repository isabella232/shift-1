<?php
namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Security\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Security\Models\Permission;

class EloquentPermissionRepository extends Repository implements PermissionRepositoryInterface
{
    /**
     * This repository manages the permissions.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }
}
