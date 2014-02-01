<?php

namespace Tectonic\Shift\Modules\Accounts\Repositories;

use Tectonic\Shift\Modules\Accounts\Roles\Search\RoleSearch;
use Tectonic\Shift\Library\SqlBaseRepository;

class SqlRoleRepository extends SqlBaseRepository implements RoleRepositoryInterface
{
	public function __construct(Role $role, RoleSearch $search)
	{
		$this->model = $role;
		$this->search = $search;
	}
}
