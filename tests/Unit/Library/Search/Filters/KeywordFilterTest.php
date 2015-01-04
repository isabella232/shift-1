<?php
namespace Tests\Unit\Library\Search\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;

class KeywordFilterTest extends \Tests\UnitTestCase
{
	public function testExpectationsWhenKeywordsAreProvided()
	{
		$mockQuery = m::spy('query');

		$filter = KeywordFilter::fromKeywords('keywords');
		$filter->applyToEloquent($mockQuery);

		$mockQuery->shouldHaveReceived('where')->with('name', 'LIKE', '%keywords%')->once();
	}

	public function testExpectationsWhenNoKeywordsAreProvided()
	{
		$mockQuery = m::spy('query');

		$filter = KeywordFilter::fromKeywords('');
		$filter->applyToEloquent($mockQuery);

		$mockQuery->shouldNotHaveReceived('where');
	}

	public function testWithCustomFieldName()
	{
		$mockQuery = m::spy('query');

		$filter = KeywordFilter::fromKeywords('keywords', 'title');
		$filter->applyToEloquent($mockQuery);

		$mockQuery->shouldHaveReceived('where')->with('title', 'LIKE', '%keywords%')->once();
	}

	public function testWithArrayOfFieldNames()
	{
		$mockQuery = m::mock('query');
		$mockQuery->shouldReceive('where')->with('title', 'LIKE', '%keywords%')->once()->andReturn($mockQuery);
		$mockQuery->shouldReceive('where')->with('name', 'LIKE', '%keywords%')->once()->andReturn($mockQuery);

		$filter = KeywordFilter::fromKeywords('keywords', ['title', 'name']);

		$filter->applyToEloquent($mockQuery);
	}
}
