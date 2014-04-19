<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use DB;
use Tectonic\Shift\Modules\Security\Models\Role;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Library\SqlBaseRepository;

class RoleRepository extends SqlBaseRepository implements RoleRepositoryInterface
{
	public function __construct(Role $role)
	{
		$this->setModel($role);
	}

    /**
     * Searches for the role that is the default role for new users.
     *
     * @return Role
     */
    public function getByDefault()
    {
        return $this->model->whereDefault(true)->first();
    }

    /**
     * Sets the default role to the role provided. Will only update the role if it has not already
     * been set as the default previously. This also occurs within a transaction.
     *
     * @param Role $role
     */
    public function setDefault(Role $role)
    {
        $defaultRole = $this->getByDefault();

        if (isset($role->id) and $defaultRole->id == $role->id) {
            return;
        }

        DB::transaction(function() use ($defaultRole, $role) {
            $defaultRole->default = false;
            $defaultRole->save();

            $role->default = true;
            $role->save();
        });
    }
}
