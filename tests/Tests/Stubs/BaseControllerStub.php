<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\BaseController;

class BaseControllerStub extends BaseController
{
	public $searchClass = 'Tests\Stubs\SearchStub';

	public function __construct($crudService)
	{
		$this->crudService = $crudService;
	}
}
