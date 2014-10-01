<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidation;
use Tectonic\Shift\Modules\Users\Repositories\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Services\UserManagementService;

class UserController extends Controller
{
	public function __construct(UserRepositoryInterface $repository, AccountValidation $validator, UserManagementService $service)
	{
		$this->repository = $repository;
        $this->validator = $validator;
        $this->crudService = $service;
	}
}
