<?php namespace Tectonic\Shift;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ShiftServiceProvider extends ServiceProvider
{
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
		
		$this->app->singleton('utility', 'Tectonic\Shift\Library\Utility');

		$aliases = AliasLoader::getInstance();
		
		$aliases->alias('Basset', 'Basset\Facade');
		$aliases->alias('Utility', 'Tectonic\Shift\Core\Facades\Utility');

		$this->registerViewFinder();
	}

	/**
	 * Register the various classes required to Bootstrap Shift
	 */
	public function boot()
	{
		$this->bootFile('commands');
		$this->bootFile('routes');
		$this->bootFile('composers');
		$this->bootFile('macros');
	}

	/**
	 * Here we register our own custom view finder, which extends the one that Laravel uses.
	 */
	public function registerViewFinder()
	{
		// $this->app->bindShared('view.finder', function($app)
		// {
		// 	$paths = $app['config']['view.paths'];

		// 	return new FileViewFinder($app['files'], $paths);
		// });
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
		require_once __DIR__.'/../../boot/'.$file.'.php';
	}
}