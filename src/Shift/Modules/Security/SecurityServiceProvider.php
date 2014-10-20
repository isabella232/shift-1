<?php
namespace Tectonic\Shift\Modules\Security;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Security\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Repositories\EloquentRoleRepository;
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
        $this->app->bind(RoleRepositoryInterface::class, EloquentRoleRepository::class);
    }

	private function registerRoleSearch()
	{
		$this->app->singleton(RoleSearch::class);
	}
}
