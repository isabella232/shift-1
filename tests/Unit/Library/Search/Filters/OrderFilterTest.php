<?php
namespace Tests\Unit\Library\Search\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\OrderFilter;

class OrderFilterTest extends \Tests\UnitTestCase
{
	private $query;

	public function init()
	{
		$this->query = m::mock('query');
	}

	public function testByFieldAndDirection()
	{
		$this->query->shouldReceive('orderBy')->with('field', 'ASC');

		$filter = OrderFilter::byFieldAndDirection('field', 'asc');
		$filter->applyToEloquent($this->query);
	}

	public function testByInputWithOnlyField()
	{
		$this->query->shouldReceive('orderBy')->with('something', 'DESC');

		$filter = OrderFilter::byInput(['order' => 'something']);
		$filter->applyToEloquent($this->query);
	}

	public function testByInputWithOnlyDirection()
	{
		$this->query->shouldReceive('orderBy')->with('id', 'ASC');

		$filter = OrderFilter::byInput(['direction' => 'asc']);
		$filter->applyToEloquent($this->query);
	}

	/**
	 * @expectedException \Exception
	 */
	public function testInvalidSortDirection()
	{
		$filter = OrderFilter::byFieldAndDirection('field', 'invalid direction');
		$filter->applyToEloquent($this->query);
	}
}
