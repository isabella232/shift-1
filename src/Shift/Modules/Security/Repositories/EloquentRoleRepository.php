<?php
namespace Tectonic\Shift\Modules\Security\Repositories;

use App;
use DB;
use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;
use Tectonic\Shift\Modules\Security\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Models\Role;

class EloquentRoleRepository extends Repository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * Returns the default role for an account.
     *
     * There is no way to do this without a set of account details.
     *
     * @return Role
     */
    public function getDefault()
    {
	    $defaultRole = $this->getBy('default', true);

	    if (!$defaultRole->isEmpty()) {
		    return $defaultRole->first();
	    }

	    return null;
    }

    /**
     * Set the default role for an account. It will also unset another role, if another
     * role is the current default role for the account.
     *
     * @param Role $role
     * @return Role
     */
    public function setDefault($role)
    {
        $updateRoles = function() use ($role) {
            $existingRole = $this->getDefault();

            if (!is_null($existingRole)) {
                if ($existingRole->id == $role->id) {
                    return $role;
                }

                $existingRole->default = false;
                $role->default = true;

                $this->saveAll($existingRole, $role);

                return $role;
            }

            $role->default = true;

            return parent::save($role);
        };

        $updateRoles->bindTo($this);

        return DB::transaction($updateRoles);
    }

	/**
	 * Saves the resource provided to the database. If the role in this case is wishing to be set as the default
     * role, then we'll save the role via the setDefault method and return this result.
	 *
	 * @param $resource
	 * @return Resource
	 */
	public function save($resource)
	{
		if ($resource->default) {
			return $this->setDefault($resource);
		}

		return parent::save($resource);
	}
}