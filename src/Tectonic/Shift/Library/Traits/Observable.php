<?php

namespace Tectonic\Shift\Library\Traits;

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
			if (method_exists($class, $event))
			{
				static::registerEvent($event, $className.'@'.$event);
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
		if (!isset($this->observables)) {
			throw new \Exception('When using the Observable trait, please ensure you\'ve defined $this->observables property as an array.');
		}

		return $this->observables;
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
			static::$dispatcher->forget("eloquent.{$event}: ".get_called_class());
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

			static::$dispatcher->listen("eloquent.{$event}: {$name}", $callback);
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