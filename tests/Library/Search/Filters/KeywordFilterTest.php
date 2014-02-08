<?php

use Mockery as m;

class KeywordFilterTest extends PHPUnit_Framework_TestCase
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
		$this->mockSearch->setParams(['keyword' => 'kirk']);

		$this->filter = new Tectonic\Shift\Library\Search\Filters\KeywordFilter;
		$this->filter->setSearch($this->mockSearch);
	}

	public function testCallingCriteriaShouldAlterTheQuery()
	{
		$this->mockQuery->shouldReceive('where')->once()->with('name', 'LIKE', '%kirk%');

		$this->filter->criteria();
	}
}
