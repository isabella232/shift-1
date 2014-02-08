<?php

namespace Tectonic\Shift\Library\Traits;

/**
 * The extender trait provides the ability for any class to easily be extended by other classes at runtime. In effect,
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

trait Extender
{
	/**
	 * Stores the objects that will be used for extender calls.
	 *
	 * @var array
	 */
	protected static $extensions = [];

	/**
	 * Whenever a method is called that does not fit the class, then Extender will loop through all registered
	 * objects to see if a method exists that is required. It will then execute and return that method's output.
	 *
	 * @param string $method
	 * @param array $arguments
	 */
	public function __call($method, $arguments)
	{
		foreach (static::$extensions as $object) {
			if (method_exists($object, $method)) {
				return $object->$method($arguments);
			}
		}

		throw new BadMethodCallException;
	}

	/**
	 * Registers a new extender object with the class. It will not register the same class twice.
	 *
	 * @param object $object
	 */
	public static function registerExtension($object)
	{
		$className = get_class($object);

		if (isset(static::$extensions[$className])) {
			throw new Exception('Object '.$className.' has already been registered with Extender.');
		}

		static::$extensions[$className] = $object;
	}

	/**
	 * Removes all registered extensions from the class.
	 */
	public static function flushExtensions()
	{
		static::$extensions = [];
	}
}
