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

		$this->mockRepository = m::mock('MockRepository');
		$this->mockRequest = m::mock('request');

		$this->controller  = new BaseControllerStub($this->mockRepository);

		Facade::setFacadeApplication(['request' => $this->mockRequest]);
	}

	public function testIndexShouldReturnSearchResults()
	{
		$this->mockRequest->shouldReceive('all')->andReturn(['param' => 'value']);

		$this->mockRepository->shouldReceive('search')->with(['param' => 'value']);

		$this->controller->index();
	}

	public function testStoreShouldCreateANewRecordViaRepository()
	{
		$this->mockRequest->shouldReceive('input')->andReturn(['name' => 'roger']);

		$this->mockRepository->shouldReceive('create')->with(['name' => 'roger']);

		$this->controller->store();
	}
}
