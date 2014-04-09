<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Search\RoleSearch;

class RoleController extends BaseController
{
	public function __construct(RoleRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}
}
