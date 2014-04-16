<?php

use Mockery as m;
use Tests\Stubs\BaseControllerStub;
use Illuminate\Support\Facades\Facade;

class BaseControllerTest extends Tests\TestCase
{
	protected $controller,
              $mockRepository,
              $mockInput,
              $mockValidator;

	public function setUp()
	{
		parent::setUp();

		$this->mockRepository  = m::mock('MockRepository');
		$this->mockValidator   = m::mock('SomeValidator');
		$this->mockInput       = m::mock('Illuminate\Http\Request');

		Input::swap($this->mockInput);

		$this->controller  = new BaseControllerStub($this->mockRepository, $this->mockValidator);
	}

	public function testIndexShouldReturnSearchResults()
	{
		$searchMock = m::mock('searchclass');
		$searchMock->shouldReceive('setParams')->with(['param' => 'value']);
		$searchMock->shouldReceive('execute')->andReturn($searchMock);
		$searchMock->shouldReceive('results')->andReturn('search results');

		$this->app->instance('Tests\Stubs\SearchStub', $searchMock);

		$this->mockInput->shouldReceive('input')->andReturn(['param' => 'value']);
		$this->assertEquals($this->controller->getIndex(), 'search results');
	}

	public function testStoreShouldCreateANewRecordViaRepository()
	{
		$this->mockInput->shouldReceive('input')->andReturn(['name' => 'roger']);

		$this->mockRepository->shouldReceive('create')->with(['name' => 'roger'])->andReturn('new resource');
		$this->mockRepository->shouldReceive('save')->with('new resource')->andReturn('saved resource');

        $this->mockValidator->shouldReceive('setInput')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('create')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

		$this->assertEquals($this->controller->postStore(), 'saved resource');
	}

	public function testShowShouldReturnTheResource()
	{
		$id = 1;
		$model = 'returned resource';

		$this->mockRepository->shouldReceive('requireById')->with($id)->andReturn($model);

		$this->assertEquals($this->controller->getShow($id), $model);
	}

	public function testUpdateShouldEditExistingRecord()
	{
		$params = ['param' => 'value'];
		$id = 1;

		$this->mockInput->shouldReceive('input')->andReturn($params);

		$this->mockRepository->shouldReceive('requireById')->with($id)->andReturn('found resource');
		$this->mockRepository->shouldReceive('update')->with('found resource', $params)->andReturn('updated resource');

        $this->mockValidator->shouldReceive('setInput')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('forMethod')->with('update')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('using')->with('found resource')->once()->andReturn($this->mockValidator);
        $this->mockValidator->shouldReceive('validate')->once();

		$this->assertEquals($this->controller->putUpdate($id), 'updated resource');
	}

	public function testDestroyShouldReturnTheDeletedResource()
	{
		$this->mockRepository->shouldReceive('requireById')->with(1)->andReturn('found resource');
		$this->mockRepository->shouldReceive('delete')->with('found resource')->andReturn('deleted resource');

		$this->assertEquals($this->controller->deleteDestroy(1), 'deleted resource');
	}
}
