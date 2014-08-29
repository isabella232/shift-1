<?php namespace Tectonic\Shift\Library\Logging;

interface ErrorLoggingInterface
{
    /**
     * Log error
     *
     * @param string $message
     * @param array  $data
     */
    public function log($message, array $data);
} 