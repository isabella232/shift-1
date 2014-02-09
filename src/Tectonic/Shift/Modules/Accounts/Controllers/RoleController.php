<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Accounts\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
	protected $roles;

	public function __construct(RoleRepositoryInterface $roles)
	{
		$this->roles = $roles;
	}
}
