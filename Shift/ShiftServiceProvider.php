<?php namespace Tectonic\Shift;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Tectonic\Shift\Library\Router;
use Tectonic\Shift\Library\Support\Asset;
use App;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $serviceProviders = [
        'Basset\BassetServiceProvider',
        'Authority\AuthorityL4\AuthorityL4ServiceProvider',
        'Mitch\LaravelDoctrine\LaravelDoctrineServiceProvider',
        'Tectonic\Shift\Library\Authorization\AuthorizationServiceProvider',
        'Tectonic\Shift\Modules\Users\UsersServiceProvider',
        'Tectonic\Shift\Modules\Startup\StartupServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Security\SecurityServiceProvider',
        'Tectonic\Shift\Modules\CustomFields\CustomFieldsServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
    ];

    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected $aliases = [
        'Basset'    => 'Basset\Facade',
        'Authority' => 'Authority\AuthorityL4\Facades\Authority',
        'Utility'   => 'Tectonic\Shift\Library\Facades\Utility'
    ];

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
        $this->registerAliases();

        $this->bootFile('bindings');

        $this->registerViewFinder();
        $this->registerRouter();
        $this->registerAuthorityConfiguration();
        $this->registerAssetContainer();

		$this->bootFile('routes');
		$this->bootFile('commands');


    }

	/**
	 * Register the various classes required to Bootstrap Shift
	 */
	public function boot()
	{
		$this->bootFile('composers');
		$this->bootFile('macros');

		$this->package('tectonic/shift');
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
			return new Router($app['events'], $app);
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
     * Register the Asset container. This is an extended version of
     * Orchetra\Asset\Factory
     */
    public function registerAssetContainer()
    {
        $this->app->bindShared('shift.asset', function($app) {
            return new Asset($app['orchestra.asset.dispatcher']);
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return $this->serviceProviders;
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
		require __DIR__.'/../boot/'.$file.'.php';
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
}
