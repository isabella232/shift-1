<?php
namespace Tectonic\Shift\Modules\Security;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Security\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Security\Repositories\EloquentRoleRepository;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Sets up the required repositories and their bindings for the Security module.
     *
     * @var array
     */
    protected $repositories = [
        RoleRepositoryInterface::class => EloquentRoleRepository::class
    ];
}
