<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Modules\Accounts\Repositories\Role;
use Tectonic\Shift\Modules\Security\Search\RoleSearch;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Library\SqlBaseRepository;

class RoleRepository extends SqlBaseRepository implements RoleRepositoryInterface
{
	public function __construct(Role $role)
	{
		$this->setModel($role);
	}
}
