<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class PermissionsService
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @var PermissionRepositoryInterface
     */
    private $permissionRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param PermissionRepositoryInterface $permissionRepository
     */
    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Allows a given resource and action for a role.
     *
     * @param $role
     * @param $resource
     * @param $action
     */
    public function allow($role, $resource, $action)
    {
        return $this->updatePermission($role, $resource, $action, true);
    }

    /**
     * Determines whether or not an authorised consumer has permission based on the required permissions.
     *
     * @param User $user
     * @param array $permissions
     */
    public function allows(User $user, array $permissions = [])
    {
        foreach ($permissions as $resource => $action) {

        }
    }

    /**
     * Deny access to a given resource.
     *
     * @param $role
     * @param $resource
     * @param $action
     * @return mixed|Resource
     */
    public function deny($role, $resource, $action)
    {
        return $this->updatePermission($role, $resource, $action, false);
    }

    /**
     * If a given role doesn't care whether or not a user has access to a permission, then call this method. This won't
     * specifically allow access, but it means that it won't get in the way of other roles that allow or deny access.
     *
     * @param $role
     * @param $resource
     * @param $action
     * @return mixed|Resource
     */
    public function inherit($role, $resource, $action)
    {
        return $this->updatePermission($role, $resource, $action, null);
    }

    /**
     * Retrieves a permission based on the role, resource and action. If none can be found, it will generate a new
     * permission object and return this instead. In this way, a permission object is always available.
     *
     * @param $role
     * @param $resource
     * @param $action
     * @param $allow
     * @return mixed|Resource
     */
    public function getPermission($role, $resource, $action)
    {
        $permission = $this->permissionRepository->getByRole($role, $resource, $action);

        if (!$permission) {
            $permission = $this->permissionRepository->getNew(['resource' => $resource, 'action' => $action]);
        }

        return $permission;
    }

    /**
     * Updates a permission for a role based on the resource and action, and defines whether the permission
     * is allowed (true), denied (false) or doesn't care (null).
     *
     * @param object $role
     * @param string $resource
     * @param string $action
     * @param mixed $allow true if allowed, false if denied, null if careless
     * @return mixed|Resource
     */
    public function updatePermission($role, $resource, $action, $allow)
    {
        $permission = $this->getPermission($role, $resource, $action);
        $permission->roleId = $role->id;
        $permission->allow = $allow;

        $this->permissionRepository->save($permission);

        return $permission;
    }

    /**
     * Determines whether a given user is allowed access based on an array of resources => required permissions.
     *
     * @param User $user
     * @param array $permissions
     */
    public function allowed(User $user, $resource, $action)
    {
        $allowed = false;

        foreach ($user->roles as $role) {
            $rolePermitted = $role->can($action, $resource);

            // Permission specifically denied
            if (false === $rolePermitted) {
                return false;
            }

            if (true === $rolePermitted) {
                $allowed = true;
            }
        }

        return $allowed;
    }
}
 