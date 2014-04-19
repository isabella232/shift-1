<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Contracts\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Should return a single record for the default role.
     *
     * @return mixed
     */
    public function getByDefault();
}
