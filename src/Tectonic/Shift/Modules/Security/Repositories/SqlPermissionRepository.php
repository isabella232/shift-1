<?php

namespace Tectonic\Shift\Modules\Security\Repositories;

use Tectonic\Shift\Modules\Security\Models\Permission;
use Tectonic\Shift\Library\Support\SqlBaseRepository;

class SqlPermissionRepository extends SqlBaseRepository implements PermissionRepositoryInterface
{
	public function __construct(Permission $permission)
	{
		$this->setModel($permission);
	}

    public function saveAll(array $permissions)
    {
        foreach ($permissions as $permission) {
            
        }
    }
}
