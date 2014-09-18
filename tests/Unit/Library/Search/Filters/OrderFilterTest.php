<?php namespace Tests\Unit\Library\Search\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;

class OrderFilterTest extends \Tests\TestCase
{
	private $queryBuilder;

	public function setUp()
	{
		parent::setUp();

		$this->queryBuilder = m::mock('querybuilder');
	}

	public function testByFieldAndDirection()
	{
		$this->queryBuilder->shouldReceive('getRootAliases')->andReturn('alias');
		$this->queryBuilder->shouldReceive('orderBy')->with('a.field', 'ASC');

		$filter = OrderFilter::byFieldAndDirection('field', 'asc');
		$filter->applyToDoctrine($this->queryBuilder);
	}

	public function testByInputWithOnlyField()
	{
		$this->queryBuilder->shouldReceive('getRootAliases')->andReturn('alias');
		$this->queryBuilder->shouldReceive('orderBy')->with('a.something', 'DESC');

		$filter = OrderFilter::byInput(['order' => 'something']);
		$filter->applyToDoctrine($this->queryBuilder);
	}

	public function testByInputWithOnlyDirection()
	{
		$this->queryBuilder->shouldReceive('getRootAliases')->andReturn('alias');
		$this->queryBuilder->shouldReceive('orderBy')->with('a.id', 'ASC');

		$filter = OrderFilter::byInput(['direction' => 'asc']);
		$filter->applyToDoctrine($this->queryBuilder);
	}
}
