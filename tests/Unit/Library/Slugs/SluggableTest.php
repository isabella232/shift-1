<?php
namespace Tests\Unit\Library\Slugs;

use Tectonic\Shift\Library\Slugs\Slug;
use Tests\AcceptanceTestCase;
use Tests\Stubs\SluggableStub;

class SluggableTest extends AcceptanceTestCase
{
    /**
     * Because the sluggable features are well-tested and used throughout the application, we simply need
     * to ensure that the slug value is created on the account when doing acceptance test cases.
     */
	public function testSlugRetrieval()
    {
        $this->assertNotEmpty($this->account->slug);
        $this->assertInstanceOf(Slug::class, $this->account->slug);
    }
}
