<?php
namespace Tectonic\Shift\Library;

use Event;
use File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as Provider;
use Illuminate\Foundation\AliasLoader;

abstract class ServiceProvider extends Provider
{
	/**
	 * Aliases to be defined and set by the service provider.
	 *
	 * @var array
	 */
	protected $aliases = [];

    /**
     * An array of the listeners that need to be registered with the system. The key should
     * refer to the event that is fired, and the value should be the class name and method
     * that will handle that event.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Register the repositories you wish to register with Shift.
     *
     * @var array
     */
    protected $repositories = [];

	/**
	 * Base register method. Simply registers the aliases and service providers defined
	 * by the service provider child class.
	 */
	public function register()
	{
		$this->registerRepositories();
		$this->registerAliases();
		$this->registerListeners();
	}

    /**
     * If there are any listeners defined on the service provider, here we'll loop through
     * them and register them as subscribers with Laravel's events system.
     */
    protected function registerListeners()
    {
        foreach ($this->listeners as $event => $listener) {
            Event::listen($event, $listener);
        }
    }

	/**
	 * Register aliases
	 *
	 * @returns void
	 */
	protected function registerAliases()
	{
		foreach ($this->aliases as $alias => $abstract) {
            AliasLoader::getInstance()->alias($alias, $abstract);
		}
	}

    /**
     * Registers the defined repository interfaces and binds them to an implementation.
     *
     * @return void
     */
    protected function registerRepositories()
    {
        foreach ($this->repositories as $interface => $repository) {
            $this->app->singleton($interface, $repository);
        }
    }
}
