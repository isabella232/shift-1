<?php
namespace Tectonic\Shift\Modules\Users;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Listeners\NotificationListener;
use Tectonic\Shift\Modules\Users\Repositories\EloquentUserRepository;

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

    /**
     * Define the listeners for this module.
     *
     * @var array
     */
    protected $listeners = [
        'Tectonic.Shift.Modules.Users.Events.UserHasRegistered' => NotificationListener::class
    ];
}
