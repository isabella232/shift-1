<?php

namespace Tectonic\Shift\Modules\Security\Contracts;

use App;
use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Security\Entities\Role;

class DoctrineRoleRepository extends Repository implements RoleRepositoryInterface
{
    /**
     * Required entity for the repository.
     *
     * @var string
     */
    protected $entity = Role::class;

    /**
     * Construct a new role entity, along with the required account.
     *
     * @param array $data
     * @return Role
     */
    public function getNew(array $data = [])
    {
        $account = App::make(CurrentAccountService::class)->getCurrentAccount();

        return new Role($account, $data['name'], $data['default']);
    }

    /**
     * Returns the default role for an account.
     *
     * There is no way to do this without a set of account details.
     *
     * @return Role
     */
    public function getByDefault()
    {
	    $defaultRole = $this->getBy('default', true);

	    if ($defaultRole) {
		    return $defaultRole[0];
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
        $existingRole = $this->getByDefault();

        if (!is_null($existingRole)) {
	        if ($existingRole->getId() == $role->getId()) {
	           return $role;
            }

            $existingRole->setDefault(false);

	        $this->saveAll($existingRole, $role);
        }

        return parent::save($role);
    }

	/**
	 * Saves the resource provided to the database.
	 *
	 * @param $resource
	 * @return Resource
	 */
	public function save($resource)
	{
		if ($resource->getDefault()) {
			return $this->setDefault($resource);
		}

		return parent::save($resource);
	}
}