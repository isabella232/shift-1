<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Authority;
use Illuminate\Database\Eloquent\Collection;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\ValueObjects\Mode;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class PermissionsService
{
    /**
     * @var PermissionRepositoryInterface
     */
    private $permissionRepository;

    /**
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Retrieves a permission based on the role, resource and action. If none can be found, it will generate a new
     * permission object and return this instead. In this way, a permission object is always available.
     *
     * @param Role $role
     * @param string $resource
     * @param string $action
     * @param string $mode
     * @return mixed|Resource
     */
    public function getPermission(Role $role, $resource, $action)
    {
        $permission = $this->permissionRepository->getByRole($role, $resource, $action);

        return $permission;
    }

    /**
     * Updates a permission for a role based on the resource and action, and defines whether the permission
     * is allowed (true), denied (false) or doesn't care (null).
     *
     * @param Role $role
     * @param string $resource
     * @param string $action
     * @param mixed $mode true if allowed, false if denied, inherit if careless
     * @return mixed|Resource
     */
    public function updatePermission(Role $role, $resource, $action, $mode)
    {
        $permission = $this->getPermission($role, $resource, $action);

        if (!$permission) {
            $permission = Permission::add($role, $resource, $action, new Mode($mode));
        }

        $permission->mode = new Mode($mode);

        $this->permissionRepository->save($permission);

        return $permission;
    }

    /**
     * Determines whether a given user is allowed access based on an array of resources => required permissions.
     *
     * @param array $permissions
     */
    public function permits(array $requiredPermissions)
    {
        $required = count($requiredPermissions);
        $allowed = 0;

        foreach ($requiredPermissions as $resource => $action) {
            if (Authority::can($action, $resource)) {
                $allowed++;
            }
        }

        return $required == $allowed;
    }

    /**
     * Updates a range of permissions for a role based on the array of input provided.
     *
     * @param Role $existingPermissions
     * @param array $permissions
     */
    public function sync(Role $role, $permissions)
    {
        foreach ($permissions as $resource => $actions) {
            $this->updateFromActions($role, $actions, $resource);
        }
    }

    /**
     * @param Role $role
     * @param $actions
     * @param $resource
     */
    protected function updateFromActions(Role $role, $actions, $resource)
    {
        foreach ($actions as $action => $mode) {
            $mode = new Mode($mode);

            $record = $role->permissions->match($resource, $action);

            if (is_null($record)) {
                $record = Permission::add($role, $resource, $action, $mode);
            }
            else {
                $record->mode = $mode;
            }

            $this->permissionRepository->save($record);
        }
    }
}
