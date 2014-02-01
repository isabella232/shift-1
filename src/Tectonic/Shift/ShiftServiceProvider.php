<?php namespace Tectonic\Shift;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ShiftServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('tectonic/shift');

		$this->app->singleton('utility', 'Tectonic\Shift\Core\Utility');

		$aliases = AliasLoader::getInstance();
		
		$aliases->alias('Basset', 'Basset\Facade');
		$aliases->alias('Utility', 'Tectonic\Shift\Core\Facades\Utility');
	}

	/**
	 * Register the various classes required to Bootstrap Shift
	 */
	public function boot()
	{
		$this->bootFile('routes.php');
		$this->bootFile('composers.php');
		$this->bootFile('macros.php');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'Basset\BassetServiceProvider'
		];
	}

	public function bootFile($file)
	{
		require __DIR__.'/../../boot/'.$file;
	}
}