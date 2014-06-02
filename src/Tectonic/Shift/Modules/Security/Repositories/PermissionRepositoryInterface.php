<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Support\BaseRepositoryInterface;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Save an array of Permissions for a given role.
     *
     * @param array $permissions
     * @return mixed
     */
    public function saveAll(array $permissions);
}
