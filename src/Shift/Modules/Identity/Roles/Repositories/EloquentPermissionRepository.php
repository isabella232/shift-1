<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Repositories;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;

class EloquentPermissionRepository extends Repository implements PermissionRepositoryInterface
{
    /**
     * Permissions are restricted by role, not account.
     *
     * @var bool
     */
    public $restrictByAccount = false;

    /**
     * This repository manages the permissions.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * Retrieves a specific permission by the role id, and if the resource or action
     * params are provided, then will find a permissions record based on those as well.
     *
     * @param integer $roleId
     * @param string $resource
     * @param string $action
     * @return mixed
     */
    public function getByRole($roleId, $resource = null, $action = null)
    {
        $query = $this->model->newQuery();
        $query->whereRoleId($roleId);

        if (!is_null($resource)) {
            $query->whereResource($resource);
        }

        if (!is_null($action)) {
            $query->whereAction($action);
        }

        return $query->get();
    }
}
