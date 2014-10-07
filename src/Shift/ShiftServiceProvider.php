<?php namespace Tectonic\Shift;

use App;
use Illuminate\Validation\Validator;
use Tectonic\Shift\Library\Router;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Library\Support\AssetFactory;
use Tectonic\Shift\Library\Validation\DoctrinePresenceVerifier;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected $aliases = [
        'Asset'         => 'Orchestra\Support\Facades\Asset',
        'Authority'     => 'Authority\AuthorityL4\Facades\Authority',
	    'EntityManager' => 'Mitch\LaravelDoctrine\EntityManagerFacade',
        'Utility'       => 'Tectonic\Shift\Library\Facades\Utility',
    ];

    /**
     * Files that require loading to bootstrap shift
     *
     * @var array
     */
    protected $filesToBoot = [
        'errors',
        'macros',
        'composers',
        'routes',
    ];

    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $serviceProviders = [
        'Authority\AuthorityL4\AuthorityL4ServiceProvider',
        'Mitch\LaravelDoctrine\LaravelDoctrineServiceProvider',
        'Orchestra\Asset\AssetServiceProvider',
        'Tectonic\Shift\Library\Authorization\AuthorizationServiceProvider',
        'Tectonic\Shift\Library\LibraryServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
        'Tectonic\Shift\Modules\Fields\FieldsServiceProvider',
        'Tectonic\Shift\Modules\Localisation\LocalisationServiceProvider',
        'Tectonic\Shift\Modules\Security\SecurityServiceProvider',
        'Tectonic\Shift\Modules\Users\UsersServiceProvider',
    ];

    /**
     * Files we need to register (include)
     *
     * @var array
     */
    protected $filesToRegister = [
        'commands',
        'composers',
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
        parent::register();

        $this->registerRouter();
        $this->registerAuthorityConfiguration();
        $this->registerValidationVerifier();
		$this->requireFiles($this->filesToRegister);
    }

	/**
	 * Register the various classes required to Bootstrap Shift
     *
     * @returns void
	 */
	public function boot()
	{
		$this->package('tectonic/shift');

		$this->requireFiles($this->filesToBoot);
	}

	/**
	 * Registers a new presence verifier for Laravel 4 validation. Specifically, this
	 * is for the use of the Doctrine ORM.
	 */
	public function registerValidationVerifier()
	{
		$this->app->bindShared('validation.presence', function()
		{
			return new DoctrinePresenceVerifier;
		});
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
	 * Helper method for requiring boot files. These are files that generally have some basic configuration,
	 * routes, global macros, or Laravel 4 commands that need to be registered.etc.
	 *
	 * @param array $files
     * @returns void
	 */
	public function requireFiles(array $files)
	{
        foreach($files as $file) {
            require __DIR__.'/../../boot/'.$file.'.php';
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
}
