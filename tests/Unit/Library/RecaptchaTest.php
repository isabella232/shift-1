<?php
namespace Tests\Unit\Library;

use Curl\Curl;
use Mockery as m;
use Tectonic\Shift\Library\Recaptcha;
use Tests\UnitTestCase;

class RecaptchaTest extends UnitTestCase
{
    private $recaptcha;
    private $mockCurl;

	public function init()
    {
        $this->mockCurl = m::mock(Curl::class);
        $this->recaptcha = new Recaptcha($this->mockCurl, 'apikey');
    }

    public function testRequests()
    {
        $params = [
            'secret' => 'apikey',
            'response' => '123456',
            'remoteip' => '1.1.1.1'
        ];

        $this->mockCurl->shouldReceive('get')->with('https://www.google.com/recaptcha/api/siteverify', $params)->once();
        $this->mockCurl->shouldReceive('setOpt')->with(CURLOPT_RETURNTRANSFER, true)->once();
        $this->mockCurl->response = '{"success": "false"}';
        $this->mockCurl->shouldReceive('close')->once();

        $this->assertEquals('false', $this->recaptcha->check('1.1.1.1', '123456'));
    }
}
