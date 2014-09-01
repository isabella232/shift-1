<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface PermissionRepositoryInterface extends RepositoryInterface
{
    /**
     * Save an array of Permissions for a given role.
     *
     * @param array $permissions
     * @return mixed
     */
    public function saveAll(array $permissions);
}
