<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

class AccountController extends BaseController
{
	public function __construct(AccountManagementService $service)
	{
		$this->crudService = $service;
	}
}
