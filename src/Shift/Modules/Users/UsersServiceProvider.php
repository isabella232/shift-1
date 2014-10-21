<?php
namespace Tectonic\Shift\Modules\Users;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Contracts\EloquentUserRepository;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Repositories defined by the users module.
     *
     * @var array
     */
    protected $repositories = [
        UserRepositoryInterface::class => EloquentUserRepository::class
    ];
}
