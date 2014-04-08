<?php

namespace Tectonic\Shift\Modules\Security\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Search\RoleSearch;

class RoleController extends BaseController
{
	protected $roles;

	public function __construct(RoleRepositoryInterface $roles, RoleSearch $search)
	{
		$this->roles  = $roles;
		$this->search = $search;
	}
}
