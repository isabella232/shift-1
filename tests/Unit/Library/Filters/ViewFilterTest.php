<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\ViewFilter;

class ViewFilterTest extends \PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockUtility = m::mock('Tectonic\Shift\Library\Utility');
		$this->filter = new ViewFilter($this->mockUtility);
	}

	public function testFilterShouldDeferToUtilityClass()
	{
		$this->mockUtility->shouldReceive('noJsonView');

		$this->filter->filter();
	}

}
