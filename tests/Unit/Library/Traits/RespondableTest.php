<?php
namespace Tests\Unit\Library\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Mockery as m;
use Tests\Stubs\RespondableStub;
use Tests\UnitTestCase;

class RespondableTest extends UnitTestCase
{
    private $respondable;
    private $mockRequest;

	public function init()
    {
        $this->respondable = new RespondableStub;
        $this->respondable->layout = new \stdClass;
        $this->respondable->layout->main = 'whatever';

        $this->mockRequest = m::mock('Illuminate\Http\Request');
        $this->mockRequest->shouldReceive('setUserResolver')->once();

        Request::swap($this->mockRequest);
    }

    public function testPjaxCheck()
    {
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->once()->andReturn('true');

        $this->assertTrue($this->respondable->isPjax());
    }

    public function testFullPageTruthyChecks()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(false);
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->once()->andReturn('false');

        $this->assertTrue($this->respondable->isFullPage());
    }

    public function testWhenWantsJsonFullPageShouldBeFalse()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(true);

        $this->assertFalse($this->respondable->isFullPage());
    }

    public function testWhenIsPjaxFullPageShouldBeFalse()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(false);
        $this->mockRequest->shouldReceive('header')->with('X-PJAX')->once()->andReturn('true');

        $this->assertFalse($this->respondable->isFullPage());
    }

    public function testJsonResponse()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(true);

        $this->assertEquals([], $this->respondable->respond('view'));
    }

    public function testPjaxAndFullpageResponses()
    {
        $this->mockRequest->shouldReceive('wantsJson')->andReturn(false);
        View::shouldReceive('make')->with('view', [], [])->once()->andReturn('view');

        $this->respondable->respond('view');

        $this->assertEquals('whatever', $this->respondable->layout->main);
    }
}
