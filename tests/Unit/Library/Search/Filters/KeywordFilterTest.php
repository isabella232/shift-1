<?php namespace Tests\Unit\Library\Search\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\KeywordFilter;

class KeywordFilterTest extends \Tests\UnitTestCase
{
	public function testExpectationsWhenKeywordsAreProvided()
	{
		$mockBuilder = m::mock('querybuilder');
		$mockBuilder->shouldReceive('getRootAliases')->andReturn('alias');
		$mockBuilder->shouldReceive('andWhere')->with('a.name LIKE :keywords');
		$mockBuilder->shouldReceive('setParameter')->with('keywords', '%keywords%');

		$filter = KeywordFilter::fromKeywords('keywords');
		$filter->applyToDoctrine($mockBuilder);
	}

	public function testExpectationsWhenNoKeywordsAreProvided()
	{
		$mockBuilder = m::mock('querybuilder');

		$mockBuilder->shouldReceive('getRootAliases')->never();
		$mockBuilder->shouldReceive('andWhere')->never();
		$mockBuilder->shouldReceive('setParameter')->never();

		$filter = KeywordFilter::fromKeywords('');
		$filter->applyToDoctrine($mockBuilder);
	}
}
