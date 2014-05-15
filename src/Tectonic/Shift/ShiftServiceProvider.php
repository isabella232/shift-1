<?php namespace Tectonic\Shift;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tectonic\Shift\Library\Router;

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

		$aliases = AliasLoader::getInstance();

		$aliases->alias('Basset', 'Basset\Facade');
		$aliases->alias('Authority', 'Authority\AuthorityL4\Facades\Authority');
		$aliases->alias('Utility', 'Tectonic\Shift\Library\Facades\Utility');

		$this->registerViewFinder();
		$this->registerRouter();
		$this->registerAuthorityConfiguration();

		$this->bootFile('bindings');
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
	 * Register the router instance. This completely overwrites the one registered by Laravel.
	 *
	 * @return void
	 */
	protected function registerRouter()
	{
		$this->app['router'] = $this->app->share(function($app)
		{
			$router = new Router($app['events'], $app);

			// If the current application environment is "testing", we will disable the
			// routing filters, since they can be tested independently of the routes
			// and just get in the way of our typical controller testing concerns.
			//if ($app['env'] == 'testing')
            if ($this->app->runningUnitTests())
			{
				$router->disableFilters();
			}

			return $router;
		});
	}

	/**
	 * Sets up the configuration required by Authority when it gets loaded.
	 */
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
