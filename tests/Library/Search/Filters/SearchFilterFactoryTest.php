<?php

use Mockery as m;

class SearchFilterFactoryTest extends PHPUnit_Framework_TestCase
{
	protected $mockSearch, $searchFilterFactory;

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockQuery = m::mock('Eloquent')->makePartial();
		$this->mockSearch = m::mock('Tectonic\Shift\Library\Search\Search')->makePartial();
		$this->mockSearch->setQuery($this->mockQuery);

		$this->searchFilterFactory = new Tests\Stubs\SearchFilterFactoryStub;
		$this->searchFilterFactory->setSearch($this->mockSearch);
	}

	// Basically just a test to ensure that our search object is being called for a method that does not exist on search filter
	public function testSetFiltersShouldRegisterNewFilters()
	{
		$mockSearchFilter = m::mock('Tectonic\Shift\Library\Contracts\SearchFilterInterface');
		$mockSearchFilter->shouldReceive('setSearch')->with($this->mockSearch);

		$this->searchFilterFactory->addFilter($mockSearchFilter);
		
		$this->assertEquals([$mockSearchFilter], $this->searchFilterFactory->getFilters());
	}
}
