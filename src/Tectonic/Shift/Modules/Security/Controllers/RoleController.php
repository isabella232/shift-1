<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Security\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
	protected $roles;

	public function __construct(RoleRepositoryInterface $roles)
	{
		$this->roles = $roles;
	}
}
