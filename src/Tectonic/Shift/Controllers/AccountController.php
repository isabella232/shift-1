<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;

class AccountController extends BaseController
{
	public function __construct(AccountManagementService $service)
	{
		$this->crudService = $service;
	}
}
