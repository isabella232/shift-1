<?php
namespace Tectonic\Shift;

use App;
use Tectonic\Shift\Commands\InstallCommand;
use Tectonic\Shift\Library\Recaptcha;
use Tectonic\Shift\Library\Router;
use Tectonic\Shift\Library\Security\HoneyPot;
use Tectonic\Shift\Library\ServiceProvider;

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
        'Utility'       => 'Tectonic\Shift\Library\Facades\Utility',
        'Recaptcha'     => 'Tectonic\Shift\Library\Facades\Recaptcha'
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
        'validators'
    ];

    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $serviceProviders = [
        'Authority\AuthorityL4\AuthorityL4ServiceProvider',
        'Orchestra\Asset\AssetServiceProvider',
        'Eloquence\EloquenceServiceProvider',
        'Tectonic\Shift\Library\Authorization\AuthorizationServiceProvider',
        'Tectonic\Shift\Library\LibraryServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
        'Tectonic\Shift\Modules\Localisation\LocalisationServiceProvider',
        'Tectonic\Shift\Modules\Security\SecurityServiceProvider',
        'Tectonic\Shift\Modules\Users\UsersServiceProvider',
        'Tectonic\Shift\Modules\Authentication\AuthenticationServiceProvider',
    ];

    /**
     * Files we need to register (include)
     *
     * @var array
     */
    protected $filesToRegister = [
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
        $this->registerRecaptcha();
        $this->registerAuthorityConfiguration();
        $this->registerHoneyPot();
		$this->requireFiles($this->filesToRegister);
    }

	/**
	 * Register the various classes required to Bootstrap Shift
     *
     * @returns void
	 */
	public function boot()
	{
		$this->package('tectonic/shift', 'shift');

		$this->requireFiles($this->filesToBoot);
        $this->bootCommands();
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

    protected function registerHoneyPot()
    {
        $this->app->singleton(HoneyPot::class, function($app) {
            return new HoneyPot($app['config']->get('shift::honeypot.api_key', ''));
        });
    }

    /**
     * Registers the recaptcha binding, and the facade/alias.
     */
    public function registerRecaptcha()
    {
        $this->app->singleton('recaptcha', function($app) {
            return new Recaptcha($app['config']->get('shift::recaptcha.keys.private'));
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

    protected function bootCommands()
    {
        $this->app->bind('command.install', InstallCommand::class);
        $this->commands('command.install');
    }
}
