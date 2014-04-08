<?php

use Mockery as m;
use Tests\Stubs\BaseControllerStub;
use Illuminate\Support\Facades\Facade;

class BaseControllerTest extends PHPUnit_Framework_TestCase
{
	protected $controller, $mockRepository;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		parent::setUp();

		$this->mockRepository  = m::mock('MockRepository');
		$this->mockSearch      = m::mock('MockSearch');
		$this->mockRequest     = m::mock('request');

		$this->controller  = new BaseControllerStub($this->mockRepository, $this->mockSearch);

		Facade::setFacadeApplication(['request' => $this->mockRequest]);
	}

	public function testIndexShouldReturnSearchResults()
	{
		$this->mockRequest->shouldReceive('input')->andReturn(['param' => 'value']);

		$this->mockSearch->shouldReceive('setParams')->with(['param' => 'value']);
		$this->mockSearch->shouldReceive('results')->with()->andReturn('search results');

		$this->assertEquals($this->controller->index(), 'search results');
	}

	public function testStoreShouldCreateANewRecordViaRepository()
	{
		$this->mockRequest->shouldReceive('input')->andReturn(['name' => 'roger']);

		$this->mockRepository->shouldReceive('create')->with(['name' => 'roger'])->andReturn('new resource');
		$this->mockRepository->shouldReceive('save')->with('new resource')->andReturn('saved resource');

		$this->assertEquals($this->controller->store(), 'saved resource');
	}

	public function testShowShouldReturnTheResource()
	{
		$id = 1;
		$model = 'returned resource';

		$this->mockRepository->shouldReceive('requireById')->with($id)->andReturn($model);

		$this->assertEquals($this->controller->show($id), $model);
	}

	public function testUpdateShouldEditExistingRecord()
	{
		$params = ['param' => 'value'];
		$model = 'returned model';
		$id = 1;

		$this->mockRequest->shouldReceive('input')->andReturn($params);

		$this->mockRepository->shouldReceive('requireById')->with($id)->andReturn('found resource');
		$this->mockRepository->shouldReceive('update')->with('found resource', $params)->andReturn('updated resource');

		$this->assertEquals($this->controller->update($id), 'updated resource');
	}

	public function testDestroyShouldReturnTheDeletedResource()
	{
		$this->mockRepository->shouldReceive('requireById')->with(1)->andReturn('found resource');
		$this->mockRepository->shouldReceive('delete')->with('found resource')->andReturn('deleted resource');

		$this->assertEquals($this->controller->destroy(1), 'deleted resource');
	}
}
