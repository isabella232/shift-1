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
		$this->mockSearch = m::mock('Tectonic\Shift\Library\Search\Search')->makePartial();
		$this->mockSearch->query = 'some query object';

		$this->searchFilter = new Tectonic\Shift\Library\Search\Filters\SearchFilter;
		$this->searchFilter->setSearch($this->mockSearch);
	}

	public function testGetQueryShouldReturnSearchQueryObject()
	{
		$this->assertEquals('some query object', $this->searchFilter->getQuery());
	}

	public function testGetParamsWithoutArgumentShouldReturnAllParams()
	{
		$this->mockSearch->shouldReceive('getParams')->andReturn(['key' => 'value']);

		$this->assertEquals(['key' => 'value'], $this->searchFilter->getParams());
	}

	public function testGetParamsWithArgumentShouldReturnParamValue()
	{
		$this->mockSearch->shouldReceive('getParams')->andReturn(['key' => 'value']);

		$this->assertEquals('value', $this->searchFilter->getParams('key'));
	}

	public function testGetParamsWithArgumentThatDoesNotExistShouldReturnNull()
	{
		$this->assertNull($this->searchFilter->getParams('key'));
	}
}
