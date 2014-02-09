<?php

use Mockery as m;
use Tests\Stubs\BaseControllerStub;

class BaseControllerTest extends PHPUnit_Framework_TestCase
{
	protected $controller, $mockRepository;

	public function tearDown()
	{
		m::close();
	}

	// public function setUp()
	// {
	// 	$this->mockRepository = m::mock('MockRepository')->makePartial();

	// 	$this->controller  = new BaseControllerStub($this->mockRepository);
	// }

	// public function testIndexShouldReturnSearchResults()
	// {
	// 	Input::shouldReceive('all')->andReturn(['param' => 'value']);

	// 	$this->mockRepository->shouldReceive('search')->with(['param' => 'value']);

	// 	$this->controller->index();
	// }

	// public function testStoreShouldCreateANewRecordViaRepository()
	// {
	// 	Input::shouldReceive('get')->andReturn(['name' => 'roger']);

	// 	$this->mockRepository->shouldReceive('create')->with(['name' => 'roger']);

	// 	$this->controller->store();
	// }
}
