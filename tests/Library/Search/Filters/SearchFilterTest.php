<?php

use Mockery as m;

class SearchFilterTest extends PHPUnit_Framework_TestCase
{
	protected $mockSearch;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockQuery = m::mock('Eloquent')->makePartial();
		$this->mockSearch = m::mock('Tectonic\Shift\Library\Search\Search')->makePartial();
		$this->mockSearch->setQuery($this->mockQuery);

		$this->searchFilter = new Tectonic\Shift\Library\Search\Filters\SearchFilter;
		$this->searchFilter->setSearch($this->mockSearch);
	}

	public function testGetQueryShouldReturnSearchQueryObject()
	{
		$this->assertEquals($this->mockQuery, $this->searchFilter->getQuery());
	}
}
