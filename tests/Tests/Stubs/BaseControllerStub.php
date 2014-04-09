<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\BaseController;

class BaseControllerStub extends BaseController
{
	public $searchClass = 'Tests\Stubs\SearchStub';

	public function __construct($repository)
	{
		$this->repository = $repository;
	}
}
