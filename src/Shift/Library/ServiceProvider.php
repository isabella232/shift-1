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
	 * Base register method. Simply registers the aliases and service providers defined
	 * by the service provider child class.
	 */
	public function register()
	{
		$this->registerServiceProviders();
		$this->registerAliases();
	}

	public function boot()
	{
		$this->setupEntityPaths();
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
		$configuration = [];

		if (File::exists($directory) and File::isDirectory($directory)) {
			$configuration[] = $directory;

			Config::set('doctrine::doctrine.metadata', append_config($configuration));
		}
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
