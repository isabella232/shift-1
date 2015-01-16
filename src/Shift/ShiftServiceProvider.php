<?php
namespace Tectonic\Shift;

use App;
use Curl\Curl;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\View;
use Tectonic\Shift\Commands\MigrateCommand;
use Tectonic\Shift\Library\Providers\Providable;
use Tectonic\Shift\Commands\SyncCommand;
use Tectonic\Shift\Commands\ResetCommand;
use Tectonic\Shift\Commands\InstallCommand;

class ShiftServiceProvider extends AggregateServiceProvider
{
    use Providable;

    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected $aliases = [
        'Asset'         => 'Orchestra\Support\Facades\Asset',
        'Utility'       => 'Tectonic\Shift\Library\Facades\Utility',
        'Recaptcha'     => 'Tectonic\Shift\Library\Facades\Recaptcha',
    ];

    /**
     * Files that require loading to bootstrap shift
     *
     * @var array
     */
    protected $filesToBoot = [
        'validators'
    ];

    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $providers = [
        'Orchestra\Asset\AssetServiceProvider',
        'Eloquence\EloquenceServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Tectonic\LaravelLocalisation\ServiceProvider',
        'Tectonic\Shift\Commands\CommandsServiceProvider',
        'Tectonic\Shift\Library\Authorization\AuthorizationServiceProvider',
        'Tectonic\Shift\Library\LibraryServiceProvider',
        'Tectonic\Shift\Library\Providers\RouteServiceProvider',
        'Tectonic\Shift\Library\Providers\AnnotationsServiceProvider',
        'Tectonic\Shift\Modules\Accounts\AccountsServiceProvider',
        'Tectonic\Shift\Modules\Configuration\ConfigurationServiceProvider',
        'Tectonic\Shift\Modules\Localisation\LocalisationServiceProvider',
        'Tectonic\Shift\Modules\Identity\Roles\RolesServiceProvider',
        'Tectonic\Shift\Modules\Identity\Users\UsersServiceProvider',
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
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        parent::register();

        $this->registerAliases();
		$this->requireFiles($this->filesToRegister);

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
		$this->requireFiles($this->filesToBoot);
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
}
