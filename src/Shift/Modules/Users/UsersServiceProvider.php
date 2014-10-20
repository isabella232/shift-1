<?php namespace Tectonic\Shift\Modules\Users;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Users\Repositories\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Repositories\DoctrineUserRepository;

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

        $this->app->singleton(UserRepositoryInterface::class, DoctrineUserRepository::class);
    }
}
