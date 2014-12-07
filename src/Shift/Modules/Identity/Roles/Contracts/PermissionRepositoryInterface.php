<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface PermissionRepositoryInterface extends RepositoryInterface
{
    /**
     * Retrieves a specific permission by the role id, and if the resource or action
     * params are provided, then will find a permissions record based on those as well.
     *
     * @param integer $roleId
     * @param string $resource
     * @param string $action
     * @return mixed
     */
    public function getByRole($roleId, $resource = null, $action = null);
}
