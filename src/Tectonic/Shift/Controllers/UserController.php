<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\Controller;
use Tectonic\Shift\Modules\Accounts\UseCases\Validators\AccountValidator;
use Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
	public function __construct(UserRepositoryInterface $repository, AccountValidator $validator)
	{
		$this->repository = $repository;
        $this->validator = $validator;
	}
}
