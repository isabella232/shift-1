<?php namespace Tests\Unit\Library\Logging;

use \Mockery as m;
use Tectonic\Shift\Library\Logging\FileErrorLogger;

class FileErrorLoggerTest extends \PHPUnit_Framework_TestCase
{
    public $writer;

    public function tearDown()
    {
        m::close();
    }

    public function setUp()
    {
        $this->writer = m::mock('Illuminate\Log\Writer');
    }

    public function testLogShouldCallLogMethod()
    {
        $this->writer->shouldReceive('error')->once();

        $fileErrorLogger = new FileErrorLogger($this->writer);
        $fileErrorLogger->log('error', ['stack' => 'trace']);
    }

}
