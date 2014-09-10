<?php namespace Tectonic\Shift\Modules\Accounts;

use App;
use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider
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
        $this->registerUserRepository();
        $this->registerAccountRepository();
        $this->registerCurrentAccountService();
    }

    /**
     * Register User repository bindings
     *
     * @return void
     */
    protected function registerUserRepository()
    {
        $this->app->bindShared('Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\Accounts\Repositories\SqlUserRepository');
        });
    }

    /**
     * Register Account repository bindings
     *
     * @return void
     */
    protected function registerAccountRepository()
    {
        $this->app->singleton('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository');
        });
    }

    /**
     * Register current account service
     *
     * @return void
     */
    protected function registerCurrentAccountService()
    {
        $this->app->singleton('Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService');
    }
}
