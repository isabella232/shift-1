<?php

namespace Tectonic\Shift\Library\Support\Exceptions;

/**
 * Class MethodNotFoundException
 *
 * Custom exception for handling method calls via magic methods (such as __call).
 *
 * @package Tectonic\Shift\Library\Support\Exceptions
 */
class MethodNotFoundException extends \Exception
{
	public function __construct($class, $method)
    {
        $this->message = 'Method ['.$method.'] does not exist on class ['.$class.']';
    }
} 