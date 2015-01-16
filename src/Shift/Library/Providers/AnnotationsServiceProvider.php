<?php
namespace Tectonic\Shift\Library\Providers;

class AnnotationsServiceProvider extends \Adamgoose\AnnotationsServiceProvider
{
    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [
        'Tectonic\Shift\Controllers\AccountController',
        'Tectonic\Shift\Controllers\AuthenticationController',
        'Tectonic\Shift\Controllers\HomeController',
        'Tectonic\Shift\Controllers\InstallationController',
        'Tectonic\Shift\Controllers\RegistrationController',
        'Tectonic\Shift\Controllers\RoleController',
        'Tectonic\Shift\Controllers\SettingController',
        'Tectonic\Shift\Controllers\UserController',
    ];

    /**
     * Load the scanned application routes.
     *
     * @return void
     */
    protected function loadScannedRoutes()
    {
        $this->app->booted(function () {
            $router = $this->app['Illuminate\Contracts\Routing\Registrar'];

            // Will configure this later.
            $router->group(['prefix' => ''], function () {
                require $this->finder->getScannedRoutesPath();
            });
        }
    }
}
