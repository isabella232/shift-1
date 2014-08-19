<?php namespace Tests\Unit\Library\Composers;

use Mockery as m;
use Tectonic\Shift\Library\Composers\LayoutsApplicationComposer;

class LayoutsApplicationComposerTest extends \PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testShouldSetSettings()
	{
		$mockView = m::mock('someview');
		$mockView->shouldReceive('with')->with('settings', []);
		$mockView->shouldReceive('with')->times(1);

		$composer = new LayoutsApplicationComposer;
		$composer->compose($mockView);
	}

}
