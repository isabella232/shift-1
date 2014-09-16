<?php namespace Tectonic\Shift\Modules\Accounts;

use App;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Illuminate\Support\ServiceProvider;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;

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
        $this->app->singleton('Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface', 'Tectonic\Shift\Modules\Accounts\Repositories\DoctrineUserRepository');
    }

    /**
     * Register Account repository bindings
     *
     * @return void
     */
    protected function registerAccountRepository()
    {
        $this->app->singleton(AccountRepositoryInterface::class, DoctrineAccountRepository::class);
    }

    /**
     * Register current account service
     *
     * @return void
     */
    protected function registerCurrentAccountService()
    {
        $this->app->singleton(CurrentAccountService::class);
    }
}
