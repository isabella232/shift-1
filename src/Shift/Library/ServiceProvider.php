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
	 * Service providers that this provider also manages.
	 *
	 * @var array
	 */
	protected $serviceProviders = [];

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
		$this->registerServiceProviders();
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
	 * Register service providers defined by the class.
	 *
	 * @return void
	 */
	protected function registerServiceProviders()
	{
		foreach ($this->serviceProviders as $provider) {
			$this->app->register($provider);
		}
	}

	/**
	 * Returns the array of service providers that are registered by this service provider.
	 *
	 * @return array
     */
	public function serviceProviders()
	{
		return $this->serviceProviders;
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

	/**
	 * Due to the way in which the configuration array is initially configured, it can mean that the first
	 * path doesn't actually exist. As a result, we want to loop through the configuration on each use case
	 * and remove any paths that don't actually exist.
	 */
	private function cleanupConfiguration(array $configuration = [])
	{
		$keysToRemove = [];

		foreach ($configuration as $key => $path) {
			if (!File::isDirectory($path)) {
				$keysToRemove[$key] = null;
			}
		}

		$diff = array_diff_key($configuration, $keysToRemove);

		return $diff;
	}

	/**
	 * Gets the service provider's directory location.
	 *
	 * @param null $path
	 * @return string
	 */
	private function getServiceProviderDirectory($path = null)
	{
		$reflector = new \ReflectionClass(get_class($this));
		$directory = [dirname($reflector->getFileName())];

		if (!is_null($path)) {
			$directory[] = $path;
		}

		return implode('/', $directory);
	}

}
