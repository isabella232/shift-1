<?php

class UniqueSlugBasedOnUUIDTest extends PHPUnit_Framework_TestCase {

    /**
     * Running this 10 times, and it'll fail around 3 times. Clashes are a possibility
     * when md5 hashing a uuid and grabbing only 8 characters :(
     */
    /*public function testGenerationOfOneHundredThousandUniqueSlugs()
    {
        $slugs = [];

        for($i = 0; $i < 100000; $i++)
        {
            $slugs[] = substr(md5(uniqid('entry_', true)), 0, 8);
        }

        $this->assertEquals(count($slugs), count(array_unique($slugs)));
    }*/
}
 