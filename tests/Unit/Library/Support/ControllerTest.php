<?php
namespace Tests\Unit\Library\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Tests\UnitTestCase;
use Tests\Stubs\ControllerStub;

class ControllerTest extends UnitTestCase
{
    protected $controller;

    public function init()
    {
        $this->controller = new ControllerStub;
    }

    public function testFullPageRequest()
    {
        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('false');
        View::shouldReceive('make')->with('shift::layouts.fullpage')->once();

        $this->controller->setup();
    }

    public function testPjaxRequest()
    {
        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->twice()->andReturn('true');
        View::shouldReceive('make')->with('shift::layouts.pjax')->once();

        $this->controller->setup();
    }
}
