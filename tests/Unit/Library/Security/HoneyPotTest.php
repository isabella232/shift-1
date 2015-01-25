<?php
namespace Tests\Unit\Library\Security;

use Illuminate\Support\Facades\Request;
use Mockery as m;
use Tectonic\Shift\Library\Security\HoneyPot;
use Tests\UnitTestCase;

class HoneyPotTest extends UnitTestCase
{
    private $honeyPot;

	public function init()
    {
        $this->honeyPot = new HoneyPot('apikey');

        $this->mockRequest = m::mock('Illuminate\Http\Request');
        $this->mockRequest->shouldReceive('setUserResolver')->once();

        Request::swap($this->mockRequest);
    }

    public function testEmptyApiKey()
    {
        $this->assertTrue((new HoneyPot(''))->allowed());
    }

    public function testIpRetrievalCheck()
    {
        $this->mockRequest->shouldReceive('server')->with('HTTP_X_FORWARDED_FOR')->once()->andReturn(null);
        $this->mockRequest->shouldReceive('ip')->once()->andReturn('ip address');

        $this->assertTrue($this->honeyPot->allowed());
    }
}
