<?php namespace Tectonic\Shift\Modules\Security;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Security\Search\RoleSearch;

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
        $this->registerRoleSearch();
    }

    /**
     * Register Role repository bindings
     */
    protected function registerRoleRepository()
    {
        $this->app->bind('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', 'Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository');
    }

	private function registerRoleSearch()
	{
		$this->app->singleton(RoleSearch::class);
	}
}
