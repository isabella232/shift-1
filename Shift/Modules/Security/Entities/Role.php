<?php

namespace Tectonic\Shift\Modules\Security\Entities;

use Mitch\LaravelDoctrine\Traits\SoftDeletes;
use Mitch\LaravelDoctrine\Traits\Timestamps;
use Tectonic\Shift\Library\Support\Database\Doctrine\Entity;

/**
 * Class Role
 *
 * Defines the role(s) a user may be assigned to as part of the system. Each role has a number
 * of rules that let the application know the resources that a user has access to. Roles are
 * an extremely important part of Shift. Users need to know what they're doing when modifying
 * role permissions.
 *
 * @entity(repositoryClass="Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository")
 * @package Tectonic\Shift\Modules\Security\Entities
 */

class Role extends Entity
{

}
