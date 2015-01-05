<?php
namespace Tectonic\Shift\Modules\Identity\Users;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Listeners\NotificationListener;
use Tectonic\Shift\Modules\Identity\Users\Repositories\EloquentUserRepository;

class UsersServiceProvider extends ServiceProvider
{
    public $defer = true;

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
        'Tectonic.Shift.Modules.Identity.Users.Events.UserHasRegistered' => NotificationListener::class
    ];

    public function provides()
    {
        return [
            UserRepositoryInterface::class
        ];
    }

    /**
     * There are some events that require the service provider to be registered.
     *
     * @return array
     */
    public function when()
    {
        return [
            'Tectonic.Shift.Modules.Identity.Users.Events.UserHasRegistered'
        ];
    }
}
