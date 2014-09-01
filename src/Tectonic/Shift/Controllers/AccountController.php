<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;

class AccountController extends Controller
{
	public function __construct(AccountManagementService $service)
	{
		$this->crudService = $service;
	}
}
