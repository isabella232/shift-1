<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Modules\Security\Models\Role;
use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * Should return a single record for the default role.
     *
     * @return mixed
     */
    public function getByDefault();

    /**
     * Set the default role to the role provided.
     *
     * @param Role $role
     */
    public function setDefault(Role $role);
}
