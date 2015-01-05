<?php
namespace Tests\Unit\Library\Slugs;

use Tectonic\Shift\Library\Slugs\Slug;
use Tests\UnitTestCase;

class SlugTest extends UnitTestCase
{
	public function testConstruction()
    {
        $slug = new Slug('precompiled slug');

        $this->assertEquals('precompiled slug', (string) $slug);
    }

    public function testEncodedSlug()
    {
        $slug = Slug::create(123);

        $this->assertSame(8, strlen((string) $slug));
    }
}
