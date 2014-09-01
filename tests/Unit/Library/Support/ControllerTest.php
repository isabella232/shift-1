<?php namespace Tests\Unit\Library\Support;

use Input;
use Mockery as m;
use Tests\TestCase;
use Tests\Stubs\ControllerStub;
use Illuminate\Support\Facades\Facade;

class ControllerTest extends TestCase
{

    protected $controller,
        $mockService,
        $mockInput;

    public function setUp()
    {
        parent::setUp();

        $this->mockService = m::mock('MockService');
        $this->mockInput   = m::mock('Illuminate\Http\Request');

        Input::swap($this->mockInput);

        $this->controller = new ControllerStub($this->mockService);
    }

    public function testGetIndex()
    {
        $searchMock = m::mock('searchclass');
        $searchMock->shouldReceive('setParams')->with(['param' => 'value']);
        $searchMock->shouldReceive('execute')->andReturn($searchMock);
        $searchMock->shouldReceive('results')->andReturn('search results');

        $this->app->instance('Tests\Stubs\SearchStub', $searchMock);

        $this->mockInput->shouldReceive('input')->andReturn(['param' => 'value']);
        $this->assertEquals($this->controller->getIndex(), 'search results');
    }

    public function testPostStore()
    {
        $params = ['param' > 'value'];

        $this->mockInput->shouldReceive('input')->andReturn($params);

        $this->mockService->shouldReceive('create')->once()->with($params);

        $this->controller->postStore();
    }

    public function testPutUpdate()
    {
        $id     = 1;
        $params = ['param' > 'value'];

        $this->mockInput->shouldReceive('input')->andReturn($params);

        $this->mockService->shouldReceive('update')->once()->with($id, $params);

        $this->controller->putUpdate($id);
    }

    public function testDeleteDestroy()
    {
        $id = 1;

        $this->mockService->shouldReceive('delete')->once()->with($id);

        $this->controller->deleteDestroy($id);
    }
}
