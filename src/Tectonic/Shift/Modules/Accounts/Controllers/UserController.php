<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidator;
use Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface;

class UserController extends BaseController
{
	public function __construct(UserRepositoryInterface $repository, AccountValidator $validator)
	{
		$this->repository = $repository;
        $this->validator = $validator;
	}
}
