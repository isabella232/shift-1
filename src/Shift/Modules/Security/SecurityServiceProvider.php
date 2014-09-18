<?php namespace Tectonic\Shift\Modules\Security;

use Tectonic\Shift\Library\ServiceProvider;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoleRepository();
    }

    /**
     * Register Role repository bindings
     */
    protected function registerRoleRepository()
    {
        $this->app->bind('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', 'Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository');
    }
}