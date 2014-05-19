<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\SqlBaseRepository;

class SqlBaseRepositoryStub extends SqlBaseRepository
{
	public function __construct($model, $search)
	{
		$this->model = $model;
		$this->search = $search;
	}
}