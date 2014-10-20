<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class EloquentRepositoryStub extends Repository
{
	public function __construct($model)
	{
		$this->model = $model;
	}
}
