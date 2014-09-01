<?php

namespace Tests\Stubs;

use Tectonic\Shift\Library\Support\Database\Eloquent\Repository;

class RepositoryStub extends Repository
{
	public function __construct($model, $search)
	{
		$this->model = $model;
		$this->search = $search;
	}
}