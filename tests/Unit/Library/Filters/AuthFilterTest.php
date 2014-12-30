<?php
namespace Tests\Unit\Library\Filters;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Mockery as m;
use Tectonic\Shift\Library\Filters\AuthFilter;
use Tests\UnitTestCase;

class AuthFilterTest extends UnitTestCase
{
    private $filter;
    private $mockRoute;
    private $mockRequest;

    public function init()
    {
        $this->mockRoute = m::mock(Route::class);
        $this->mockRequest = m::mock(Request::class);

        $this->filter = new AuthFilter;
    }

	public function testGuestResponse()
    {
        Auth::shouldReceive('guest')->once()->andReturn(true);
        Redirect::shouldReceive('to')->with('/')->once()->andReturn('response');

        $this->assertEquals('response', $this->filter->filter($this->mockRoute, $this->mockRequest));
    }
}
