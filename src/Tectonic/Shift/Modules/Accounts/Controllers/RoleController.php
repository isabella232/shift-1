<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Core\BaseController;
use Tectonic\Shift\Accounts\Repositories\RoleRepositoryInterface;

class RoleController extends BaseController
{
	protected $roles;

	public function __construct(RoleRepositoryInterface $roles, Input $input)
	{
		$this->roles = $roles;
	}
	
	public function getIndex()
	{
		return $this->roles->search($input->get());
	}

}
