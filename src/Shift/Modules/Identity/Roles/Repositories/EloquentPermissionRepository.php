<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;

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
