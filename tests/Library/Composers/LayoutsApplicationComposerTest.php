<?php

use Mockery as m;
use Tectonic\Shift\Library\Composers\LayoutsApplicationComposer;

class LayoutsApplicationComposerTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockView = m::mock('View');
		$this->composer = new LayoutsApplicationComposer;
	}

	public function testShouldSetSettings()
	{
		$this->mockView->shouldReceive('with')->with('settings', []);

		$this->composer->compose($this->mockView);
	}

}