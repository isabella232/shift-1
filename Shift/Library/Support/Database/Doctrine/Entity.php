<?php

namespace Tectonic\Shift\Library\Support\Database\Doctrine;

use BadMethodCallException;

/**
 * Class Entity
 * @package Tectonic\Shift\Library\Support\Database\Doctrine
 */
abstract class  Entity
{
    /**
     * If a given property exists, then let's support a getter for that property.
     *
     * @param $method
     * @param array $arguments
     * @throws BadMethodCallException
     */
    public function __call($method, array $arguments = [])
    {
        $methodPossibility = substr($method, 0, 3);
        $property = camel_case(substr($method, 3));

        if (property_exists($this, $property)) {
            switch ($methodPossibility) {
                case 'get':
                    return $this->$property;
                    break;
                case 'set':
                    $this->$property = array_pop($arguments);
                    return;
                    break;
            }
        }

        throw new BadMethodCallException(static::class.'::'.$method.' does not exist.');
    }
}
