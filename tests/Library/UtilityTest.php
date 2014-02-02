<?php

use Mockery as m;
use Request;
use View;

class UtilityTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->request = m::mock('Request');
		$this->view = m::mock('View');

		$this->utility = new Tectonic\Shift\Library\Utility($this->request, $this->view);
	}

	public function tearDown()
	{
		m::close();
	}

	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage Utility::eventName expects at least 2 parameters (only 1 provided). The first parameter should be the domain of the event, with extra arguments being used to craft the details of the event name.
	 */
	public function testEventNameShouldThrowExceptionWithTooFewArgs()
	{
		$this->utility->eventName('not enough args');
	}

	public function testEventNameCalledWithTwoArgsShouldReturnExactlyTwoParts()
	{
		$this->assertEquals('shift::loading', $this->utility->eventName('shift', 'loading'));
	}

	public function testEventNameCalledWithMoreThanTwoArgsShouldBuildTheStringWithDecimalsAfterTheFirst()
	{
		$this->assertEquals('shift::run.some.long.event.name', $this->utility->eventName('shift', 'run', 'some', 'long', 'event', 'name'));
	}

	public function testNoJsonViewShouldNotReturnTheViewIfTheRequestWantsJson()
	{
		$this->request->shouldReceive('wantsJson')->andReturn(true);

		$this->assertNull($this->utility->noJsonView());
	}

	public function testNoJsonViewShouldReturnTheViewIfTheRequestDoesNotWantJson()
	{
		$this->request->shouldReceive('wantsJson')->andReturn(false);
		$this->view->shouldReceive('make')->with('shift::layouts.application')->andReturn('view');

		$this->assertEquals('view', $this->utility->noJsonView());
	}
}
