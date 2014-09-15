<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;
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
     * Returns the default role for an account.
     *
     * There is no way to do this without a set of account details.
     *
     * @return Role
     */
    public function getByDefault()
    {
        $query = $this->createQuery();

        $query->where($query->expr()->eq($this->field('default'), true));

        return $query->getResult();
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

        if ($existingRole->getId() == $role->getId()) {
            return $existingRole;
        }

        $existingRole->setDefault(false);
        $role->setDefault(true);

        $this->saveAll($existingRole, $role);

        return $role;
    }
}