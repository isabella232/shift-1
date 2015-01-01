<?php
namespace Tests\Unit\Library\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Tests\Stubs\RespondableStub;
use Tests\UnitTestCase;

class RespondableTest extends UnitTestCase
{
    private $respondable;

	public function init()
    {
        $this->respondable = new RespondableStub;
    }

    public function testPjaxCheck()
    {
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('true');

        $this->assertTrue($this->respondable->isPjax());
    }

    public function testFullPageTruthyChecks()
    {
        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('false');

        $this->assertTrue($this->respondable->isFullPage());
    }

    public function testWhenWantsJsonFullPageShouldBeFalse()
    {
        Request::shouldReceive('wantsJson')->andReturn(true);

        $this->assertFalse($this->respondable->isFullPage());
    }

    public function testWhenIsPjaxFullPageShouldBeFalse()
    {
        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('true');

        $this->assertFalse($this->respondable->isFullPage());
    }

    public function testJsonResponse()
    {
        Request::shouldReceive('wantsJson')->andReturn(true);

        $this->assertEquals([], $this->respondable->respond('view'));
    }

    public function testPjaxResponse()
    {
        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('true');
        View::shouldReceive('make')->with('view', [])->once()->andReturn('view');

        $this->assertEquals('view', $this->respondable->respond('view'));
    }

    public function testFullPageResponse()
    {
        $this->respondable->layout = new \stdClass;

        Request::shouldReceive('wantsJson')->andReturn(false);
        Request::shouldReceive('header')->with('X-PJAX')->once()->andReturn('false');
        View::shouldReceive('make')->with('view', [])->once()->andReturn('view');

        $this->respondable->respond('view');

        $this->assertEquals('view', $this->respondable->layout->main);
    }
}
