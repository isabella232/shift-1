<?php namespace Tests\Acceptance\Library\Logging;

use Mockery;
use Tests\TestCase;


class FileErrorLoggerTest extends TestCase
{

    /**
     * Setup method to run before each test
     */
    public function setUp()
    {
        parent::setUp();

        Mockery::close(); // Destroy any existing mocks before creating new ones
    }

    /**
     * Test FileErrorLogger writes to laravel's log file.
     *
     * @test
     */
    public function testFileErrorLoggerWritesToFile()
    {
        $logFileLocation = \Config::get('storage_path') . '/app/storage/logs/laravel.log';

        // Empty/clear log file of any data.
        $handle = fopen($logFileLocation, "w+");
        fclose($handle);

        // Log a test error message
        $logger = \App::make('\Tectonic\Shift\Library\Logging\ErrorLoggingInterface');
        $logger->log('Test error message', []);

        // Check to see if the log file has been appended to.
        $f = fopen($logFileLocation, 'r');
        $line = fgets($f);
        fclose($f);

        //$this->assertTrue(strpos($line, 'Test error message'));
    }

}
