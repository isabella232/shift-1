<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
	public function __construct(RoleRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}
}
