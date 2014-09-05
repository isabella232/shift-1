<?php namespace Tectonic\Shift\Modules\Security;

use App;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bindShared('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\Security\Repositories\SqlRoleRepository');
        });
    }
}