<?php
namespace Tectonic\Shift\Modules\Identity\Roles;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Facades\PermissionResources;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentRoleRepository;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentPermissionRepository;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionResourcesService;

class RolesServiceProvider extends ServiceProvider
{
    public $defer = true;

    /**
     * @var array
     */
    protected $aliases = [
        'PermissionResources' => PermissionResources::class
    ];

    /**
     * Sets up the required repositories and their bindings for the Security module.
     *
     * @var array
     */
    protected $repositories = [
        RoleRepositoryInterface::class => EloquentRoleRepository::class,
        PermissionRepositoryInterface::class => EloquentPermissionRepository::class
    ];

    public function register()
    {
        parent::register();

        $this->app->singleton('permission.resources', PermissionResourcesService::class);
    }

    public function provides()
    {
        return [
            'permission.resources',
            'PermissionResources',
            RoleRepositoryInterface::class,
            PermissionRepositoryInterface::class
        ];
    }
}
