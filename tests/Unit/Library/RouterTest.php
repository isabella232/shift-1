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
        $this->router->shouldReceive('get')->once()->with('users/new', ['as' => "users.new", 'uses' => "User@getNew"]);
        $this->router->shouldReceive('get')->once()->with('users/{id}', ['as' => "users.show", 'uses' => "User@getShow"]);
        $this->router->shouldReceive('put')->once()->with('users/{id}', ['as' => "users.update", 'uses' => "User@putUpdate"]);
        $this->router->shouldReceive('get')->once()->with('users', ['as' => "users.index", 'uses' => "User@getIndex"]);
        $this->router->shouldReceive('post')->once()->with('users', ['as' => "users.create", 'uses' => "User@postStore"]);
        $this->router->shouldReceive('delete')->once()->with('users/{id}', ['as' => "users.delete", 'uses' => "User@deleteDestroy"]);
        $this->router->shouldReceive('delete')->once()->with('users', ['as' => "users.bulkDelete", 'uses' => "User@deleteDestroy"]);

        $this->router->collection('users', 'User');
    }
}
