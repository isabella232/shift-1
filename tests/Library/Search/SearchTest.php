<?php

use \Mockery as m;

class SearchTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	// Really only one method here that needs to be tested, all the rest are dead simple
	public function testResultsShouldCallAllFilterCriteriaAndReturnResults()
	{
		$mockNameFilter = m::mock('Tectonic\Shift\Library\Search\Filters\SearchFilter')->makePartial();
		$mockNameFilter->shouldReceive('criteria')->twice();
		
		$mockQuery = m::mock('Tectonic\Shift\Library\Contracts\QueryInterface');
		$mockQuery->shouldReceive('paginate')->andReturn(['items']);

		$search = new Tests\Stubs\SearchStub;

		$filterFactory = m::mock('Tectonic\Shift\Library\Search\Filters\SearchFilterFactory')->makePartial();

		$filterFactory->setSearch($search);
		$filterFactory->addFilter($mockNameFilter);
		$filterFactory->addFilter($mockNameFilter);
		
		$search->setFilters($filterFactory);
		$search->setQuery($mockQuery);
		
		$this->assertEquals(['items'], $search->results());
	}


}
