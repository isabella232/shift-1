<?php namespace Tectonic\Shift\Modules\Users;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Contracts\EloquentUserRepository;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
}
