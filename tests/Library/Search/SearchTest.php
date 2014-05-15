<?php

use \Mockery as m;

class SearchTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->mockQuery = m::mock('Eloquent');
		$this->search = new Tests\Stubs\SearchStub;
	}

	// Really only one method here that needs to be tested, all the rest are dead simple
    public function testExecuteShouldCallFiltersAndExecuteSearch()
    {
        $mockNameFilter = m::mock('Tectonic\Shift\Library\Search\Filters\SearchFilterInterface')->makePartial();
        $mockNameFilter->shouldReceive('criteria')->twice();
        $mockNameFilter->shouldReceive('setSearch')->twice();

        $this->mockQuery->shouldReceive('paginate')->andReturn(['items']);

        $this->search->setQuery($this->mockQuery);
        $this->search->addFilter($mockNameFilter);
        $this->search->addFilter($mockNameFilter);

        $this->assertEquals($this->search, $this->search->execute());
    }

	public function testResultsShouldCallAllFilterCriteriaAndReturnResults()
	{
        $mockNameFilter = m::mock('Tectonic\Shift\Library\Search\Filters\SearchFilterInterface')->makePartial();
        $mockNameFilter->shouldReceive('criteria')->once();
        $mockNameFilter->shouldReceive('setSearch')->once();

        $this->mockQuery->shouldReceive('paginate')->andReturn(['result items']);

        $this->search->setQuery($this->mockQuery);
        $this->search->addFilter($mockNameFilter);

		$this->assertEquals(['result items'], $this->search->execute()->results());
	}

	public function testGetParamsShouldReturnAllParamsAsArray()
	{
		$this->search->setParams(['key' => 'value']);

		$this->assertEquals(['key' => 'value'], $this->search->getParams());
	}

	public function testGetParamWithArgumentShouldReturnParamValue()
	{
		$this->search->setParams(['key' => 'value']);

		$this->assertEquals('value', $this->search->getParam('key'));
	}

	public function testGetParamWithArgumentThatDoesNotExistShouldReturnNull()
	{
		$this->assertNull($this->search->getParam('key'));
	}

	public function testHasParamShouldReturnTrueIfParamsProvidedContainKey()
	{
		$this->search->setParams(['keyCheck' => 'yup']);

		$this->assertTrue($this->search->hasParam('keyCheck'));
	}
}
