<?php

use Mockery as m;

class OrderFilterTest extends PHPUnit_Framework_TestCase
{
	protected $mockSearch;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockQuery = m::mock('Eloquent');

		$this->mockSearch = m::mock('Tectonic\Shift\Library\Search\Search')->makePartial();
		$this->mockSearch->setQuery($this->mockQuery);

		$this->filter = new Tectonic\Shift\Library\Search\Filters\OrderFilter;
		$this->filter->setSearch($this->mockSearch);
	}

	public function testCallingCriteriaWithoutParamsShouldCallDefaults()
	{
		$this->mockQuery->shouldReceive('orderBy')->once()->with('id', 'DESC');

		$this->filter->criteria($this->mockSearch);
	}

	public function testCallingCriteriaWithCustomOrderParamsShouldCallQueryAppropriately()
	{
		$this->mockSearch->setParams(['order' => 'name', 'direction' => 'asc']);

		$this->mockQuery->shouldReceive('orderBy')->once()->with('name', 'ASC');

		$this->filter->criteria($this->mockSearch);
	}

	public function testCallingCriteriaWithInvalidDirectionShouldStillUseDefault()
	{
		$this->mockSearch->setParams(['order' => 'field', 'direction' => 'bogus']);

		$this->mockQuery->shouldReceive('orderBy')->once()->with('field', 'DESC');

		$this->filter->criteria($this->mockSearch);
	}
}
