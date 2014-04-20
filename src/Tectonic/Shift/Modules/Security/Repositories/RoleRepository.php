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
        $roleRepository = $this;

        $defaultRole = $this->getByDefault();

        if (isset($role->id) and $defaultRole->id == $role->id) {
            return;
        }

        DB::transaction(function() use ($defaultRole, $role, $roleRepository) {
            $defaultRole->default = false;
            $role->default = true;

            $defaultRole->save();
            $role->save();
        });
    }

    /**
     * Overloads the parent method so as to provide some functionality based on the default attribute. If it's
     * been provided, then it will call the setDefault method to handle the functionality.
     *
     * @param $role
     * @return Role
     */
    public function save($role)
    {
        if ($role->default && $role->isDirty('default')) {
            $this->setDefault($role);
        }

        // If the role was already saved via setDefault, we don't want to call it again
        if ($role->isDirty()) {
            parent::save($role);
        }

        return $role;
    }
}
