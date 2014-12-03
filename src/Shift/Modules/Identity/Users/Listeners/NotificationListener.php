<?php
namespace Tectonic\Shift\Modules\Identity\Users\Listeners;

use Tectonic\Application\Commanding\DefaultCommandBus;
use Tectonic\Application\Eventing\EventListener;
use Tectonic\Shift\Modules\Identity\Users\Commands\SendRegistrationEmailCommand;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Events\UserHasRegistered;

class NotificationListener extends EventListener
{
    /**
     * @var DefaultCommandBus
     */
    private $commandBus;

    /**
     * @param DefaultCommandBus $commandBus
     */
    public function __construct(DefaultCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * When a user has registered, we need to send them a confirmation email. This email
     * contains their confirmation token and is a call to action.
     *
     * @param UserHasRegistered $event
     */
    public function whenUserHasRegistered(UserHasRegistered $event)
    {
        $this->commandBus->execute(new SendRegistrationEmailCommand($event->user));
    }
}
