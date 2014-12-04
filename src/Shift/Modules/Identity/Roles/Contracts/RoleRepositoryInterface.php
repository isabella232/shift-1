<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Contracts;

use Tectonic\Shift\Library\Support\Database\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * Should return a single record for the default role.
     *
     * @return mixed
     */
    public function getDefault();

    /**
     * Set the default role to the role provided.
     *
     * @param $role
     */
    public function setDefault($role);
}
