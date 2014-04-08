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
		$aliases->alias('Authority', 'Authority\AuthorityL4\Facades\Authority');
		$aliases->alias('Utility', 'Tectonic\Shift\Core\Facades\Utility');

		$this->registerViewFinder();
		$this->registerAuthorityConfiguration();
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

	public function registerAuthorityConfiguration()
	{
		$this->app['config']->set('authority-l4::initialize', function($authority) {
			$user = $authority->getCurrentUser();
		});
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
			'Basset\BassetServiceProvider',
			'Authority\AuthorityL4\AuthorityL4ServiceProvider'
		];
	}

	/**
	 * Helper method for requiring boot files. These are files that generally have some basic configuration,
	 * routes, global macros, or Laravel 4 commands that need to be registered.etc.
	 *
	 * @param string $file
	 * @requires $file
	 */
	public function bootFile($file)
	{
		require_once __DIR__.'/../../boot/'.$file.'.php';
	}
}