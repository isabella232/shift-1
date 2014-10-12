<?php

namespace Tectonic\Shift\Library;

use File;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as Provider;

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
     * An array of the listeners that need to be registered with the system.
     *
     * @var array
     */
    protected $listeners = [];

	/**
	 * Base register method. Simply registers the aliases and service providers defined
	 * by the service provider child class.
	 */
	public function register()
	{
		$this->registerServiceProviders();
		$this->registerAliases();
	}

	/**
	 * When booting any service provider issued by Shift or any child packages, it's important
	 * that upon boot we register any entity paths that the system wants to use. This is used
	 * for database migrations via Doctrine.
	 */
	public function boot()
	{
		$this->setupEntityPaths();
	}

    /**
     * If there are any listeners defined on the service provider, here we'll loop through
     * them and register them as subscribers with Laravel's events system.
     */
    protected function registerListeners()
    {
        foreach ($this->listeners as $listener) {
            Event::subscribe(new $listener);
        }
    }

	/**
	 * Register aliases
	 *
	 * @returns void
	 */
	protected function registerAliases()
	{
		$aliasLoader = AliasLoader::getInstance();

		foreach($this->aliases as $key => $value)
		{
			$aliasLoader->alias($key, $value);
		}
	}

	/**
	 * Register service providers defined by the class.
	 *
	 * @return void
	 */
	protected function registerServiceProviders()
	{
		foreach($this->serviceProviders as $provider)
		{
			$this->app->register($provider);
		}
	}

	/**
	 * Method to automatically inject entity paths for doctrine usage. This is particularly
	 * useful when wanting to automatically generate database schema design based on entities.
	 */
	protected function setupEntityPaths()
	{
		$directory = $this->getServiceProviderDirectory('Entities');
		$configuration = $this->cleanupConfiguration(Config::get('doctrine::doctrine.metadata', []));

		if (File::isDirectory($directory)) {
			$configuration[] = $directory;
		}

		Config::set('doctrine::doctrine.metadata', append_config($configuration));
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