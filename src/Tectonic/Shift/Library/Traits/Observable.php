<?php

namespace Tectonic\Shift\Library\Traits;

use Illuminate\Events\Dispatcher;

trait Observable
{
	/**
	 * The event dispatcher instance.
	 *
	 * @var \Illuminate\Events\Dispatcher
	 */
	protected static $dispatcher;

	/**
	 * Register an observer with the object.
	 *
	 * @param  object  $class
	 * @return void
	 */
	public static function observe($class)
	{
		$className = get_class($class);

		// When registering a model observer, we will spin through the possible events
		// and determine if this observer has that method. If it does, we will hook
		// it into the model's event system, making it convenient to watch these.
		foreach (static::getObservableEvents() as $event)
		{
			$method = static::eventMethod($event);

			if (method_exists($class, $method))
			{
				static::registerEvent($event, $className.'@'.$method);
			}
		}
	}

	/**
	 * Get the observable event names.
	 *
	 * @return array
	 */
	public static function getObservableEvents()
	{
		if (!isset(static::$observables)) {
			throw new \Exception('When using the Observable trait, please ensure you\'ve defined $this->observables property as an array.');
		}

		return static::$observables;
	}

	/**
	 * Turns an event into a method name, by replacing . and _ with a capital of the following word. For example,
	 * if the event is something like user.updating, then the method would become userUpdating.
	 *
	 * @param string $event
	 * @return string
	 */
	protected static function eventMethod($event)
	{
		$callback = function($matches) {
			return strtoupper($matches[1][1]);
		};

		return preg_replace_callback('/([._-][a-z])/i', $callback, $event);
	}

	/**
	 * Fire the given event for the object.
	 *
	 * @param  string  $event
	 * @param  bool    $halt
	 * @return mixed
	 */
	protected function fireEvent($event, $halt = true)
	{
		if (!isset(static::$dispatcher)) return true;

		// We will append the names of the class to the event to distinguish it from
		// other model events that are fired, allowing us to listen on each model
		// event set individually instead of catching event for all the models.
		$event = "{$event}: ".get_class($this);
		
		return static::$dispatcher->fire($event, $this);
	}

	/**
	 * Remove all of the event listeners for the class.
	 *
	 * @return void
	 */
	public static function flushEventListeners()
	{
		if ( ! isset(static::$dispatcher)) return;

		$instance = new static;

		foreach ($instance->getObservableEvents() as $event)
		{
			static::$dispatcher->forget("{$event}: ".get_called_class());
		}
	}

	/**
	 * Register a model event with the dispatcher.
	 *
	 * @param  string  $event
	 * @param  \Closure|string  $callback
	 * @return void
	 */
	protected static function registerEvent($event, $callback)
	{
		if (isset(static::$dispatcher))
		{
			$name = get_called_class();
			
			static::$dispatcher->listen("{$event}: {$name}", $callback);
		}
	}

	/**
	 * Get the event dispatcher instance.
	 *
	 * @return \Illuminate\Events\Dispatcher
	 */
	public static function getEventDispatcher()
	{
		return static::$dispatcher;
	}

	/**
	 * Set the event dispatcher instance.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $dispatcher
	 * @return void
	 */
	public static function setEventDispatcher(Dispatcher $dispatcher)
	{
		static::$dispatcher = $dispatcher;
	}

	/**
	 * Unset the event dispatcher for models.
	 *
	 * @return void
	 */
	public static function unsetEventDispatcher()
	{
		static::$dispatcher = null;
	}
}