<?php namespace Tectonic\Shift;

use App;
use Tectonic\Shift\Library\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected $aliases = [
        'Basset'        => 'Basset\Facade',
        'Authority'     => 'Authority\AuthorityL4\Facades\Authority',
        'Utility'       => 'Tectonic\Shift\Library\Facades\Utility',
	    'EntityManager' => 'Mitch\LaravelDoctrine\EntityManagerFacade',
    ];

    /**
     * Files that require loading to bootstrap shift
     *
     * @var array
     */
    protected $filesToBoot = [
        'macros',
        'composers',
    ];

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
        'Tectonic\Shift\Library\LibraryServiceProvider',
        'Tectonic\Shift\Modules\Users\UsersServiceProvider',
        //'Tectonic\Shift\Modules\Startup\StartupServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Security\SecurityServiceProvider',
        'Tectonic\Shift\Modules\CustomFields\CustomFieldsServiceProvider',
        'Tectonic\Shift\Modules\Localisation\LocalisationServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
    ];

    /**
     * Files we need to register (include)
     *
     * @var array
     */
    protected $filesToRegister = [
        'routes',
        'commands'
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
        $this->registerServiceProviders();
        $this->registerAliases();
        $this->registerRouter();
        $this->registerAuthorityConfiguration();
		$this->requireFiles($this->filesToRegister);
    }

	/**
	 * Register the various classes required to Bootstrap Shift
     *
     * @returns void
	 */
	public function boot()
	{
		$this->requireFiles($this->filesToBoot);

		$this->package('tectonic/shift');
	}

	/**
	 * Sets up the configuration required by Authority when it gets loaded.
     *
     * @returns void
	 */
	public function registerAuthorityConfiguration()
	{
		$this->app['config']->set('authority-l4::initialize', function($authority) {
			$user = $authority->getCurrentUser();
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
    }

	/**
	 * Helper method for requiring boot files. These are files that generally have some basic configuration,
	 * routes, global macros, or Laravel 4 commands that need to be registered.etc.
	 *
	 * @param array $files
     * @returns void
	 */
	public function requireFiles(array $files)
	{
        foreach($files as $file)
        {
            require __DIR__.'/../boot/'.$file.'.php';
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
     * Register service providers
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
}
