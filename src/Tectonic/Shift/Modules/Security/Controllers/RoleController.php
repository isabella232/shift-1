<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Security\Services\RoleManagementService;
use Tectonic\Shift\Modules\Security\Validators\RoleValidator;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
	public function __construct(RoleManagementService $roleManagementService)
	{
		$this->crudService = $roleManagementService;
	}
}
