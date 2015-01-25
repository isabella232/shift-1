<?php
namespace Tests\Unit\Library\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery as m;
use Tectonic\Shift\Library\Facades\Consumer;
use Tectonic\Shift\Library\Middleware\AuthMiddleware;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tests\UnitTestCase;

class AuthMiddlewareTest extends UnitTestCase
{
    private $middleware;
    private $mockRequest;

    public function init()
    {
        $this->mockRequest = m::mock(Request::class);
        $this->mockGuard = m::mock(\Illuminate\Contracts\Auth\Guard::class);

        $this->middleware = new AuthMiddleware($this->mockGuard);
    }

	public function testGuestResponse()
    {
        $this->mockGuard->shouldReceive('guest')->once()->andReturn(true);

        Redirect::shouldReceive('route')->with('home')->once()->andReturn('response');

        $this->assertEquals('response', $this->middleware->handle($this->mockRequest, function() {}));
    }

    public function testAuthorisedUser()
    {
        $mockUser = m::mock(User::class);

        $this->mockGuard->shouldReceive('guest')->once()->andReturn(false);
        $this->mockGuard->shouldReceive('user')->once()->andReturn($mockUser);

        Consumer::shouldReceive('set')->once();

        $this->middleware->handle($this->mockRequest, function() {});
    }
}
