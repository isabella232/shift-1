<?php

use Mockery as m;

class RouterTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->router = m::mock('Tectonic\Shift\Library\Router')->makePartial();
	}

	public function tearDown()
	{
		m::close();
	}

	public function testCallWithoutOptionsShouldCreateDefaultRoutes()
	{
		$this->router->shouldReceive('get')->twice();
		$this->router->shouldReceive('delete')->twice();
		$this->router->shouldReceive('put')->once();
		$this->router->shouldReceive('post')->once();

		$this->router->collection('something', 'SomeClass');
	}
}
