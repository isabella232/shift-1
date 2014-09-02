<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Library\Support\Database\Doctrine\Repository;

class DoctrineRoleRepository extends Repository implements RoleRepositoryInterface
{
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
        
        $existingRole->default = false;
        $role->default = true;

        $this->save($existingRole);
        $this->save($role);

        return $role;
    }
}