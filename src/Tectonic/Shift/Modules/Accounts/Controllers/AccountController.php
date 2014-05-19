<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidator;

class AccountController extends BaseController
{
	public function __construct(RoleRepositoryInterface $repository, RoleValidator $roleValidator)
	{
		$this->repository = $repository;
        $this->validator = $roleValidator;
	}
}
