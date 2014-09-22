<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\Controller;

class ControllerStub extends Controller
{
	public $searchClass = 'Tests\Stubs\SearchStub';

	public function __construct($crudService)
	{
		$this->crudService = $crudService;
	}
}
