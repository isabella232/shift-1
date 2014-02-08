<?php

use Mockery as m;

use Tests\Stubs\ObservableStub;
use Tests\Stubs\ObserverStub;

class ObservableTest extends PHPUnit_Framework_TestCase
{
	public $mockDispatcher, $mockObserver;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockDispatcher = m::mock('Illuminate\Events\Dispatcher')->makePartial();
		$this->observer = new ObserverStub;

		ObservableStub::setEventDispatcher($this->mockDispatcher);

		$this->observableClass = new ObservableStub;
	}

	public function testObserveShouldRegisterAppropriateEvents()
	{
		// TODO: get proper arguments sorted: $this->mockDispatcher->shouldReceive('listen')->with("some.method: Tests\Stubs\ObserverStub")->with('Tests\Stubs\ObserverStub@someMethod');
		$this->mockDispatcher->shouldReceive('listen');

		ObservableStub::observe($this->observer);
	}

}