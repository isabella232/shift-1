<?php

namespace Tectonic\Shift\Modules\Security\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;
use Tectonic\Shift\Modules\Accounts\Entities\Accountable;

/**
 * Class Role
 *
 * Defines the role(s) a user may be assigned to as part of the system. Each role has a number
 * of rules that let the application know the resources that a user has access to. Roles are
 * an extremely important part of Shift. Users need to know what they're doing when modifying
 * role permissions.
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository")
 * @table(name="roles")
 */
class Role extends Entity
{
    use Accountable;
    use Timestamps;
    use SoftDeletes;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="integer" options={"unsigned"=true})
     */
    private $access;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="boolean" options={"default"=0})
     */
    private $default;

    /**
     * @OneToMany(targetEntity="Tectonic\Shift\Modules\Security\Entities\Permission", mappedBy="roleId")
     */
    private $permissions;

    /**
     * @OneToMany(targetEntity="Tectonic\Shift\Modules\Users\Entities\Users", mappedBy="userId")
     */
    private $users;
}

