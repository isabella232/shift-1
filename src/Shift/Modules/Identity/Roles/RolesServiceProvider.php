<?php
namespace Tectonic\Shift\Modules\Identity\Roles;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentRoleRepository;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentPermissionRepository;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Sets up the required repositories and their bindings for the Security module.
     *
     * @var array
     */
    protected $repositories = [
        RoleRepositoryInterface::class => EloquentRoleRepository::class,
        PermissionRepositoryInterface::class => EloquentPermissionRepository::class
    ];

    public function provides()
    {
        return [
            RoleRepositoryInterface::class,
            PermissionRepositoryInterface::class
        ];
    }
}
