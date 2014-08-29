<?php namespace Tectonic\Shift\Library\Logging;

use Illuminate\Log\Writer;

/**
 * Class FileErrorLogger
 *
 * Logger errors to a file.
 *
 * @package Tectonic\Shift\Library\Logging
 */
class FileErrorLogger implements ErrorLoggingInterface
{
    /**
     * @var \Illuminate\Log\Writer
     */
    protected $log;

    /**
     * @param \Illuminate\Log\Writer $log
     */
    public function __construct(Writer $log)
    {
        $this->log = $log;
    }

    /**
     * Log error to a file
     *
     * @param array $data
     */
    public function log($message, array $data)
    {
        $this->log->error($message, $data);
    }
}