<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;

class AccountController extends Controller
{
	public function __construct(AccountsService $service)
	{
		$this->crudService = $service;
	}
}
