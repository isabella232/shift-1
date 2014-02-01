<?php

use Mockery as m;

class SqlRoleRepositoryTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->model = m::mock('Model');
		$this->search = m::mock('Search');
		$this->repository = m::mock('Tests\Stubs\SqlBaseRepositoryStub')->makePartial();

		$this->repository->model  = $this->model;
		$this->repository->search = $this->search;
	}

	public function testSearch()
	{
		$params = [];

		$this->search->shouldReceive('setParams')->with($params);
		$this->search->shouldReceive('results')->andReturn([]);

		$this->assertEquals([], $this->repository->search($params));
	}
}
