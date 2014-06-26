<?php namespace Tests\Unit\Library\Search\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\SearchFilter;

class SearchFilterTest extends \PHPUnit_Framework_TestCase
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

		$this->searchFilter = new SearchFilter;
		$this->searchFilter->setSearch($this->mockSearch);
	}

	// Basically just a test to ensure that our search object is being called for a method that does not exist on search filter
	public function testGetQueryShouldReturnSearchQueryObject()
	{
		$this->assertEquals($this->mockQuery, $this->searchFilter->getQuery());
	}
}
