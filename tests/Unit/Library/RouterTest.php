<?php namespace Tests\Unit\Library;

use Mockery as m;
use Tectonic\Shift\Library\Router;

class RouterTest extends \Tests\UnitTestCase
{
    private $router;

    public function init()
	{
        $this->router = m::mock(Router::class)->makePartial();
	}

	public function testCallWithoutOptionsShouldCreateDefaultRoutes()
	{
		$this->router->shouldReceive('get')->times(3);
		$this->router->shouldReceive('delete')->twice();
		$this->router->shouldReceive('put')->once();
		$this->router->shouldReceive('post')->once();

		$this->router->collection('something', 'SomeClass');
	}

    public function testCompleteSetup()
    {
        $this->router->shouldReceive('get')->once()->with('users/new', 'User@getNew');
        $this->router->shouldReceive('get')->once()->with('users/{id}', 'User@getShow');
        $this->router->shouldReceive('put')->once()->with('users/{id}', 'User@putUpdate');
        $this->router->shouldReceive('get')->once()->with('users', 'User@getIndex');
        $this->router->shouldReceive('post')->once()->with('users', 'User@postStore');
        $this->router->shouldReceive('delete')->once()->with('users/{id}', 'User@deleteDestroy');
        $this->router->shouldReceive('delete')->once()->with('users', 'User@deleteDestroy');

        $this->router->collection('users', 'User');
    }
}
