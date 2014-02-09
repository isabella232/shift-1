<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\BaseController;

class BaseControllerStub extends BaseController
{
	public function __construct($repository)
	{
		$this->repository = $repository;
	}
}
