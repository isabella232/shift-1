<?php
namespace Tests\Unit\Library\Security;

use Illuminate\Support\Facades\Request;
use Tectonic\Shift\Library\Security\HoneyPot;
use Tests\UnitTestCase;

class HoneyPotTest extends UnitTestCase
{
    private $honeyPot;

	public function init()
    {
        $this->honeyPot = new HoneyPot('apikey');
    }

    public function testEmptyApiKey()
    {
        $this->assertTrue((new HoneyPot(''))->allowed());
    }

    public function testIpRetrievalCheck()
    {
        Request::shouldReceive('server')->with('HTTP_X_FORWARDED_FOR')->once()->andReturn(null);
        Request::shouldReceive('ip')->once()->andReturn('ip address');

        $this->assertTrue($this->honeyPot->allowed());
    }
}
