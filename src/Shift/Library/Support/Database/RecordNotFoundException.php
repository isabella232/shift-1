<?php

namespace Tectonic\Shift\Library\Support\Database;

/**
 * Class RecordNotFoundException
 *
 * Used whenever a single cannot be found.
 *
 * @package Tectonic\Shift\Library\Support\Database
 */
class RecordNotFoundException extends \Exception
{
    /**
     * @param string $resource String representation of the resource, such as a model or entity name
     * @param int|string $value The value used for the search
     */
    public function __construct($resource, $value)
    {
        $this->message = 'Could not find record for ['.$resource.'] using ['.$value.']';
    }
}
