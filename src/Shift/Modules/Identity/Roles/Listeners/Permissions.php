<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Listeners;

use Tectonic\Application\Commanding\DefaultCommandBus;
use Tectonic\Shift\Modules\Identity\Roles\Events\RoleWasCreated;

class Permissions
{
    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

    /**
     * @param ValidationCommandBus $commandBus
     */
    public function __construct(DefaultCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

	public function whenRoleWasCreated(RoleWasCreated $event)
    {
        $permissions = Input::get('permissions', []);
        $command = new UpdateRolePermissionsCommand($event->role, $permissions);

        $this->commandBus->execute($command);
    }
}
