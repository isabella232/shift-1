<?php

namespace Tectonic\Shift\Modules\Security\Entities;

use Doctrine\ORM\Mapping as ORM;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class Role
 *
 * Defines the role(s) a user may be assigned to as part of the system. Each role has a number
 * of rules that let the application know the resources that a user has access to. Roles are
 * an extremely important part of Shift. Users need to know what they're doing when modifying
 * role permissions.
 *
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository")
 * @ORM\Table(name="roles")
 */
class Permission extends Entity
{
    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private $default;

    /**
     * @ORM\ManyToOne(targetEntity="Tectonic\Shift\Modules\Security\Entities\Role")
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Tectonic\Shift\Modules\Users\Entities\Users", mappedBy="userId")
     */
    private $users;
}
