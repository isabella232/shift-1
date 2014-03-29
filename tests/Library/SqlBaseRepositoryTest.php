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

	public function testFindByIdShouldReturnASpecificRecord()
	{
		$record = ['name' => 'Me'];

		$this->model->shouldReceive('findOrFail')->with(1)->andReturn($record);

		$this->assertEquals($record, $this->repository->findById(1));
	}

	public function testDeleteShouldRemoveAndReturnDeletedRecord()
	{
		$resource = m::mock('someobject');
		$resource->shouldReceive('delete')->once();

		$this->assertEquals($resource, $this->repository->delete($resource));
	}

	public function testDeleteRecordPermanently()
	{
		$resource = m::mock('someobject');
		$resource->shouldReceive('forceDelete')->once();

		$this->assertEquals($resource, $this->repository->delete($resource, true));
	}

	public function testCreateShouldMakeAndReturnANewRecord()
	{
		$record = 'record';

		$this->model->shouldReceive('newInstance')->andReturn($record);

		$this->assertEquals($record, $this->repository->create());
	}

	public function testUpdateShouldSaveAndReturnExistingRecord()
	{
		$params = ['testParam' => 1];

		$foundRecord = m::mock('FoundRecord');
		$foundRecord->shouldReceive('fill')->with($params);
		$foundRecord->shouldReceive('save');

		$this->repository->shouldReceive('find')->with(1)->andReturn($foundRecord);

		$this->assertEquals($foundRecord, $this->repository->update($foundRecord, $params));
	}
}
