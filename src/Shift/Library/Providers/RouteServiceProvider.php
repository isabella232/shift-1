<?php
namespace Tectonic\Shift\Library\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Tectonic\Shift\Controllers';

    /**
     * A collection of the application's route middleware (previously known as Filters in L4)
     *
     * @var array
     */
    protected $routeMiddleware = [
        'shift.account.exception' => 'Tectonic\Shift\Library\Middleware\AccountExceptionMiddleware',
        'shift.auth'              => 'Tectonic\Shift\Library\Middleware\AuthMiddleware',
        'shift.account'           => 'Tectonic\Shift\Library\Middleware\AccountMiddleware',
        'shift.install'           => 'Tectonic\Shift\Library\Middleware\InstallationMiddleware'
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->app['router']->middleware($key, $middleware);
        }
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->loadRoutesFrom(realpath(__DIR__.'/../../../..').'/boot/routes.php');
    }
}