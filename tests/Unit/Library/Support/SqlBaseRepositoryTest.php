<?php namespace Tests\Unit\Library\Support;

use Mockery as m;

class SqlRoleRepositoryTest extends \PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->model = m::mock('Model');
		$this->repository = m::mock('Tests\Stubs\SqlBaseRepositoryStub')->makePartial();

		$this->repository->setModel($this->model);
	}

	public function testGetByIdShouldReturnASpecificRecord()
	{
		$record = ['name' => 'Me'];

		$this->model->shouldReceive('find')->with(1)->andReturn($record);

		$this->assertEquals($record, $this->repository->getById(1));
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

	public function testGetNewShouldMakeAndReturnANewRecord()
	{
		$record = 'record';

		$this->model->shouldReceive('newInstance')->andReturn($record);

		$this->assertEquals($record, $this->repository->getNew());
	}

	public function testUpdateShouldSaveAndReturnExistingDirtyRecord()
	{
		$params = ['testParam' => 1];

		$foundRecord = m::mock('FoundRecord');
		$foundRecord->shouldReceive('fill')->with($params);
		$foundRecord->shouldReceive('save');
		$foundRecord->shouldReceive('getDirty')->andReturn(true);

		$this->repository->shouldReceive('find')->with(1)->andReturn($foundRecord);

		$this->assertEquals($foundRecord, $this->repository->update($foundRecord, $params));
	}

	public function testUpdateShouldTouchAndReturnExistingCleanRecord()
	{
		$params = ['testParam' => 1];

		$foundRecord = m::mock('FoundRecord');
		$foundRecord->shouldReceive('fill')->with($params);
		$foundRecord->shouldReceive('touch');
		$foundRecord->shouldReceive('getDirty')->andReturn(false);

		$this->repository->shouldReceive('find')->with(1)->andReturn($foundRecord);

		$this->assertEquals($foundRecord, $this->repository->update($foundRecord, $params));
	}
}
