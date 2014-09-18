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
 * @ORM\Entity(repositoryClass="Tectonic\Shift\Modules\Security\Repositories\DoctrinePermissionRepository")
 * @ORM\Table(name="permissions")
 */
class Permission extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 */
	protected $roleId;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	protected $action;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string")
	 */
	protected $resource;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Tectonic\Shift\Modules\Security\Entities\Role")
     */
    protected $role;

	public function __construct(Role $role, $resource, $action, $type)
	{
		$this->setRole($role);
		$this->setResource($resource);
		$this->setAction($action);
		$this->setType($type);
	}
}
