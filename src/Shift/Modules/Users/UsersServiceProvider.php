<?php namespace Tectonic\Shift\Modules\Users;

use App;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
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
        $this->app->bindShared('Tectonic\Shift\Modules\Users\Repositories\UserRepositoryInterface', function() {
            return App::make('Tectonic\Shift\Modules\Users\Repositories\DoctrineUserRepository');
        });
    }
}
