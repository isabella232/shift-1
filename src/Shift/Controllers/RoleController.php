<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Security\Services\RoleManagementService;
use Tectonic\Shift\Modules\Security\Search\RoleSearch;

class RoleController extends Controller
{
	public $searchClass = RoleSearch::class;

	public function __construct(RoleManagementService $roleManagementService)
	{
		$this->crudService = $roleManagementService;
	}
}
