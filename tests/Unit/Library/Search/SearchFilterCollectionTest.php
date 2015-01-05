<?php
namespace Tests\Unit\Library\Search;

use Mockery as m;
use Tectonic\Shift\Library\Search\Filters\SearchFilterInterface;
use Tectonic\Shift\Library\Search\SearchFilterCollection;
use Tests\UnitTestCase;

class SearchFilterCollectionTest extends UnitTestCase
{
    private $searchFilterCollection;
    private $mockFilter1;
    private $mockFilter2;

    public function init()
    {
        $this->mockFilter1 = m::mock(SearchFilterInterface::class);
        $this->mockFilter2 = m::mock(SearchFilterInterface::class);

        $this->searchFilterCollection = new SearchFilterCollection;
        $this->searchFilterCollection->add($this->mockFilter1);
        $this->searchFilterCollection->add($this->mockFilter2);
    }

    public function testCurrent()
    {
        $this->assertEquals($this->mockFilter1, $this->searchFilterCollection->current());
    }

    public function testKey()
    {
        $this->assertEquals(0, $this->searchFilterCollection->key());
    }

    public function testNext()
    {
        $this->searchFilterCollection->next();

        $this->assertEquals(1, $this->searchFilterCollection->key());
    }

    public function testRewind()
    {
        $this->searchFilterCollection->next();
        $this->searchFilterCollection->rewind();

        $this->assertEquals(0, $this->searchFilterCollection->key());
    }

    public function testValidity()
    {
        $this->searchFilterCollection->next();
        $this->searchFilterCollection->next();
        $this->searchFilterCollection->next();

        $this->assertFalse($this->searchFilterCollection->valid());
    }
}
