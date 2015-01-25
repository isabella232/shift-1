<?php
namespace Tests\Unit\Library\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Mockery as m;
use Tests\UnitTestCase;
use Tests\Stubs\ControllerStub;

class ControllerTest extends UnitTestCase
{
    protected $controller;
    private $mockRequest;

    public function init()
    {
        $this->controller = new ControllerStub;
        $this->mockRequest = m::mock('Illuminate\Http\Request');
        $this->mockRequest->shouldReceive('setUserResolver')->once();

        Request::swap($this->mockRequest);
    }

    public function testFullPageRequest()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(false);
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->once();

        View::shouldReceive('make')->with('shift::layouts.fullpage', [], [])->once();

        $this->controller->setup();
    }

    public function testPjaxRequest()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(false);
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->twice()->andReturn('true');

        View::shouldReceive('make')->with('shift::layouts.pjax', [], [])->once();

        $this->controller->setup();
    }
}
