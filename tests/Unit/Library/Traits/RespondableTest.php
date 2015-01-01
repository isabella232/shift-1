<?php
namespace Tests\Unit\Library\Traits;

use Illuminate\Support\Facades\Request;
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
}
