<?php namespace Tectonic\Shift\Providers;

use Adamgoose\AnnotationsServiceProvider as ServiceProvider;

class AnnotationsServiceProvider extends ServiceProvider {

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
        'Tectonic\Shift\Controllers\HomeController',
        'Tectonic\Shift\Controllers\InstallationController',
        'Tectonic\Shift\Controllers\RegistrationController',
        'Tectonic\Shift\Controllers\AuthenticationController',
        'Tectonic\Shift\Controllers\UserController',
        'Tectonic\Shift\Controllers\SettingController',
        'Tectonic\Shift\Controllers\RoleController',
    ];



}