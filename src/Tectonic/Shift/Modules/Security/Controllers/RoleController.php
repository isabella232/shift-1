<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Security\Services\RoleManagementService;

class RoleController extends BaseController
{
	public function __construct(RoleManagementService $roleManagementService)
	{
		$this->crudService = $roleManagementService;
	}
}
