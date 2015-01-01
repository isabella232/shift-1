<?php
namespace Tests\Unit\Library\Support\Database;

use Tectonic\Shift\Library\Support\Database\RecordNotFoundException;
use Tests\UnitTestCase;

class RecordNotFoundExceptionTest extends UnitTestCase
{
	public function testExceptionMessage()
    {
        $exception = new RecordNotFoundException('Resource', 'value');

        $this->assertEquals('Could not find record for [Resource] using [value]', $exception->getMessage());
    }
}
