<?php

namespace Tectonic\Shift\Controllers;

use Tectonic\Shift\Library\Support\BaseController;
use Tectonic\Shift\Modules\Accounts\UseCases\Validators\AccountValidator;
use Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface;

class UserController extends BaseController
{
	public function __construct(UserRepositoryInterface $repository, AccountValidator $validator)
	{
		$this->repository = $repository;
        $this->validator = $validator;
	}
}
