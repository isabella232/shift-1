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

	public function testSearchShouldReturnSearchResults()
	{
		$params = [];

		$this->search->shouldReceive('setParams')->with($params);
		$this->search->shouldReceive('results')->andReturn([]);

		$this->assertEquals([], $this->repository->search($params));
	}

	public function testAllShouldReturnAllResults()
	{
		$this->model->shouldReceive('all')->andReturn(['all']);

		$this->assertEquals(['all'], $this->repository->all());
	}

	public function testFindShouldReturnASpecificRecord()
	{
		$record = ['name' => 'Me'];

		$this->model->shouldReceive('findOrFail')->with(1)->andReturn($record);

		$this->assertEquals($record, $this->repository->find(1));
	}

	public function testDeleteShouldRemoveAndReturnDeletedRecord()
	{
		$this->repository->shouldReceive('find')->andReturn($this->model);
		$this->model->shouldReceive('delete')->andReturn(true);
		$this->model->shouldReceive('findOrFail')->with(1)->andReturn([]);

		$this->assertEquals($this->model, $this->repository->delete(1));
	}

	public function testCreateShouldMakeAndReturnANewRecord()
	{
		$params = ['testParam' => 1];
		$record = 'record';

		$this->model->shouldReceive('create')->with($params)->andReturn($record);

		$this->assertEquals($record, $this->repository->create($params));
	}

	public function testUpdateShouldSaveAndReturnExistingRecord()
	{
		$params = ['testParam' => 1];

		$foundRecord = m::mock('FoundRecord');
		$foundRecord->shouldReceive('fill')->with($params);
		$foundRecord->shouldReceive('save');

		$this->repository->shouldReceive('find')->with(1)->andReturn($foundRecord);

		$this->assertEquals($foundRecord, $this->repository->update(1, $params));
	}
}
