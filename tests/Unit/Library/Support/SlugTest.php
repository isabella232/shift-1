<?php namespace Tests\Unit\Library\Support;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Tectonic\Shift\Library\Support\Slug;

class SlugTest extends PHPUnit_Framework_TestCase
{

    public function testSlugGeneratesEightCharacterStringByDefault()
    {
        $slug = (new Slug())->encode(1);

        $this->assertEquals(8, strlen($slug));
    }

    public function testSlugGeneratesEightCharacterStringWithNoNumbers()
    {
        $slug = (new Slug())->encode(1);

        // strcspn() returns the length of the part that does not contain any integers.
        // We compare that with the slug length, and if they differ, then there must have been an integer.
        $this->assertEquals(8, strcspn($slug, '0123456789'));
    }

}
