<?php namespace Tests\Unit\Library;

use Mockery as m;

class RouterTest extends \Tests\UnitTestCase
{
    private $router;

    public function setUp()
	{
        parent::setUp();

		$this->router = m::mock('Tectonic\Shift\Library\Router')->makePartial();
	}

    /**
     * @covers Router::collection
     */
	public function testCallWithoutOptionsShouldCreateDefaultRoutes()
	{
		$this->router->shouldReceive('get')->twice();
		$this->router->shouldReceive('delete')->twice();
		$this->router->shouldReceive('put')->once();
		$this->router->shouldReceive('post')->once();

		$this->router->collection('something', 'SomeClass');
	}

    /**
     * Offers a more complete test of the routing functionality. Made some changes, decided to add a new
     * test rather than modify an existing one which works just fine. //- Kirk
     *
     * @covers Router::collection
     */
    public function testCompleteSetup()
    {
        $this->router->shouldReceive('get')->once()->with('users/{id}', 'User@getShow');
        $this->router->shouldReceive('put')->once()->with('users/{id}', 'User@putUpdate');
        $this->router->shouldReceive('get')->once()->with('users', 'User@getIndex');
        $this->router->shouldReceive('post')->once()->with('users', 'User@postStore');
        $this->router->shouldReceive('delete')->once()->with('users/{id}', 'User@deleteDestroy');
        $this->router->shouldReceive('delete')->once()->with('users', 'User@deleteDestroy');

        $this->router->collection('users', 'User');
    }
}
