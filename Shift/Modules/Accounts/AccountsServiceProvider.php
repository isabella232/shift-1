<?php namespace Tectonic\Shift\Modules\Accounts;

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
        $this->app->bindShared('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface', function() {
            return App::make('Tectonic\Shift\Modules\Accounts\Repositories\SqlAccountRepository');
        });
    }

    /**
     * Register the various classes required to Bootstrap Shift
     */
    public function boot()
    {

    }
}
