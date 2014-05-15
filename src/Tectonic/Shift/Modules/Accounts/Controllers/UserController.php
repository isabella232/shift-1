<?php

namespace Tectonic\Shift\Modules\Accounts\Controllers;

use Tectonic\Shift\Library\BaseController;
use Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface;

class UserController extends BaseController
{
	public function __construct(UserRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}
}
