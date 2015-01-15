<?php
namespace Tectonic\Shift;

use App;
use Curl\Curl;
use Illuminate\Support\Facades\View;
use Tectonic\Shift\Commands\MigrateCommand;
use Tectonic\Shift\Library\Recaptcha;
use Tectonic\Shift\Commands\SyncCommand;
use Tectonic\Shift\Commands\ResetCommand;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Commands\InstallCommand;
use Tectonic\Shift\Library\Security\HoneyPot;

class ShiftServiceProvider extends ServiceProvider
{
    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected $aliases = [
        'Asset'         => 'Orchestra\Support\Facades\Asset',
        'Form'          => 'Illuminate\Html\FormFacade',
        'Html'          => 'Illuminate\Html\HtmlFacade',
        'Utility'       => 'Tectonic\Shift\Library\Facades\Utility',
        'Recaptcha'     => 'Tectonic\Shift\Library\Facades\Recaptcha',
    ];

    /**
     * A collection of the application's route middleware (previously known as Filters in L4)
     *
     * @var array
     */
    protected $routeMiddleware = [
        'shift.account.exception' => 'Tectonic\Shift\Library\Middleware\AccountExceptionMiddleware',
        'shift.auth'              => 'Tectonic\Shift\Library\Middleware\AuthFilter',
        'shift.account'           => 'Tectonic\Shift\Library\Middleware\AccountFilter',
        'shift.install'           => 'Tectonic\Shift\Library\Middleware\InstallationFilter'
    ];

    /**
     * Files that require loading to bootstrap shift
     *
     * @var array
     */
    protected $filesToBoot = [
        //'macros',
        'validators'
    ];

    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $serviceProviders = [
        'Orchestra\Asset\AssetServiceProvider',
        'Eloquence\EloquenceServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Tectonic\LaravelLocalisation\ServiceProvider',
        'Tectonic\Shift\Library\Authorization\AuthorizationServiceProvider',
        'Tectonic\Shift\Library\LibraryServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
        'Tectonic\Shift\Modules\Localisation\LocalisationServiceProvider',
        'Tectonic\Shift\Modules\Identity\Roles\RolesServiceProvider',
        'Tectonic\Shift\Modules\Identity\Users\UsersServiceProvider',
        'Tectonic\Shift\Modules\Authentication\AuthenticationServiceProvider',
        'Tectonic\Shift\Providers\RouteServiceProvider',
        'Tectonic\Shift\Providers\AnnotationsServiceProvider',
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

        $this->registerRecaptcha();
        $this->registerHoneyPot();
		$this->requireFiles($this->filesToRegister);
        $this->registerRouteMiddleware($this->routeMiddleware);

        // Define view namespace, as $this->package() doesn't exist anymore in L5
        View::addNamespace('shift', realpath(__DIR__.'/../../views'));
    }

	/**
	 * Register the various classes required to Bootstrap Shift
     *
     * @returns void
	 */
	public function boot()
	{
		//$this->package('tectonic/shift');
		$this->requireFiles($this->filesToBoot);
        $this->bootCommands();
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
            return new Recaptcha(new Curl, $app['config']->get('shift::recaptcha.keys.private'));
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
        foreach ($files as $file) {
            require __DIR__.'/../../boot/'.$file.'.php';
        }
    }

    /**
     * Sets up the required commands that are necessary for Shift operations
     */
    protected function bootCommands()
    {
        $this->app->bind('command.shift.install', InstallCommand::class);
        $this->commands('command.shift.install');

        $this->app->bind('command.shift.reset', ResetCommand::class);
        $this->commands('command.shift.reset');

        $this->app->bind('command.shift.migrate', MigrateCommand::class);
        $this->commands('command.shift.migrate');

        $this->app->bind('command.shift.sync', SyncCommand::class);
        $this->commands('command.shift.sync');
    }

    /**
     * Register route middleware
     *
     * @param array $routeMiddleware
     */
    protected function registerRouteMiddleware($routeMiddleware)
    {
        foreach($routeMiddleware as $key => $middleware)
        {
            $this->app['router']->middleware($key, $middleware);
        }
    }
}
