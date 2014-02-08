<?php

namespace Tectonic\Shift\Library\Traits;

/**
 * The polymorphic trait provides the ability for any class to easily be extended by other classes at runtime. In effect,
 * it provides polymorphism without having to be redeveloped each time it is required. This is particularly useful in cases
 * where we may have numerous classes that need to extend models or repositories from multiple locations. Single inheritance
 * in these cases just won't do.
 *
 * It should be noted that the trait, when calling for missing methods on the class, will loop through each object provided
 * for polymorphism and check to see if that method exists. In this way, it is quite possible for two classes to have the
 * same method name during execution, so you must be aware of this fact and debug accordingly if your cusotm method is not
 * being called.
 *
 * To use, simply register your class with the class that you wish to polymorphise. Like so:
 *
 *   Animal::registerPolymorphic(new Dog);
 *
 * @author Kirk Bushell
 * @date 8th Februrary 2014
 */

use BadMethodCallException;
use Exception;

trait Polymorphic
{
	/**
	 * Stores the objects that will be used for polymorphic calls.
	 *
	 * @var array
	 */
	protected static $polymorphicObjects = [];

	public function __call($method, $arguments)
	{
		foreach (static::$polymorphicObjects as $object) {
			if (method_exists($object, $method)) {
				return $object->$method($arguments);
			}
		}

		throw new BadMethodCallException;
	}

	/**
	 * Registers a new polymorphing object with the class. It will not register the same class twice.
	 *
	 * @param object $object
	 */
	public static function registerPolymorphic($object)
	{
		$className = get_class($object);

		if (isset(static::$polymorphicObjects[$className])) {
			throw new Exception('Object '.$className.' has already been registered with Polymorphic.');
		}

		static::$polymorphicObjects[$className] = $object;
	}
}
