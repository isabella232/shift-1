<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\ViewFilter;
use Tests\TestCase;

class ViewFilterTest extends TestCase
{
	private $mockUtility;
	private $filter;

	public function setUp()
	{
		parent::setUp();

		$this->mockUtility = m::mock('Tectonic\Shift\Library\Utility');
		$this->filter = new ViewFilter($this->mockUtility);
	}

	public function testFilterShouldDeferToUtilityClass()
	{
		$this->mockUtility->shouldReceive('noJsonView');

		$this->filter->filter();
	}
}
