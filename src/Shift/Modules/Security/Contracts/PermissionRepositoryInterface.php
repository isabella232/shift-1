<?php
namespace Tectonic\Shift\Modules\Security\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface PermissionRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns the permissions for a given role.
     *
     * @param object $role
     * @param string $resource
     * @param string $action
     * @return mixed
     */
    public function getByRole($role, $resource = null, $action = null);
}
