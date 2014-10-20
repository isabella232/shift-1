<?php namespace Tests\Unit\Library\Traits;

use Mockery as m;

use Tests\Stubs\ObservableStub;
use Tests\Stubs\ObserverStub;

class ObservableTest extends \Tests\UnitTestCase
{

    public $mockDispatcher, $mockObserver;

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        $this->mockDispatcher = m::mock('Illuminate\Events\Dispatcher')->makePartial();
        $this->observer       = new ObserverStub;

        ObservableStub::setEventDispatcher($this->mockDispatcher);

        $this->observableClass = new ObservableStub;
    }

    public function testGetObservableEventsShouldReturnEvents()
    {
        $this->assertEquals(['some.method', 'another.event'], ObservableStub::getObservableEvents());
    }

    public function testFlushEventListenersShouldClearAllRegisteredHooks()
    {
        $this->mockDispatcher->shouldReceive('listen');
        $this->mockDispatcher->shouldReceive('forget')->twice();

        ObservableStub::observe($this->observer);
        ObservableStub::flushEventListeners();
    }

    public function testObserveShouldRegisterAppropriateEvents()
    {
        // TODO: get proper arguments sorted: $this->mockDispatcher->shouldReceive('listen')->with("some.method: Tests\Stubs\ObserverStub")->with('Tests\Stubs\ObserverStub@someMethod');
        $this->mockDispatcher->shouldReceive('listen');

        ObservableStub::observe($this->observer);
    }

    public function testFireEventShouldCallMethodsOnRelevantClasses()
    {
        $this->mockDispatcher->shouldReceive('listen');
        $this->mockDispatcher->shouldReceive('fire');

        ObservableStub::observe($this->observer);

        $observable = new ObservableStub;
        $observable->fire();
    }

    public function testGetEventDispatcherShouldReturnRegisteredDispatcher()
    {
        $this->assertEquals(ObservableStub::getEventDispatcher(), $this->mockDispatcher);
    }

    public function testUnsetEventDispatcherShouldRemovedRegisteredDispatcher()
    {
        ObservableStub::unsetEventDispatcher();

        $this->assertNull(ObservableStub::getEventDispatcher());
    }
}
