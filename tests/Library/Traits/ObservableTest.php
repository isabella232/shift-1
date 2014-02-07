<?php

use Mockery as m;

use Tests\Stubs\ObservableStub;

class ObservableTest extends PHPUnit_Framework_TestCase
{
	public $mockDispatcher;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockDispatcher = m::mock('Illuminate\Events\Dispatcher')->makePartial();
		$this->mockObserver = m::mock('SomeObserver')->makePartial();

		ObservableStub::setEventDispatcher($this->mockDispatcher);
	}

	public function testObserveShouldRegisterAppropriateEvents()
	{
		$this->mockObserver->shouldReceive('someMethod')->once();
		$this->mockDispatcher->shouldReceive('listen')->once()->with("some.method: SomeObserver");

		ObservableStub::observe($this->mockObserver);
	}


}