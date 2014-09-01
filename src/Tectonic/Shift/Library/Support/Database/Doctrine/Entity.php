<?php

namespace Tectonic\Shift\Library\Support\Database\Doctrine;

abstract class Entity
{
    /**
     * If a given property exists, then let's support a getter for that property.
     *
     * @param $method
     * @param array $arguments
     */
    public function __call($method, array $arguments = [])
    {
        if (substr($method, 0, 3) == 'get') {
            $property = substr($method, 2);

            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }
    }
} 