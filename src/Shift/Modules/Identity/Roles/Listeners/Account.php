<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Listeners;

use Tectonic\Application\Commanding\DefaultCommandBus;
use Tectonic\Shift\Modules\Accounts\Events\AccountWasCreated;

class Account
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

	public function whenAccountWasCreated(AccountWasCreated $event)
    {
        $command = new SetupDefaultRolesCommand($event->account);

        $this->commandBus->execute($command);
    }
}
