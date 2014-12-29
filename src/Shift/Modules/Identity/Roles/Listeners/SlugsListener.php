<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Listeners;

use Tectonic\Shift\Library\Slugs\CreateSlugCommand;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;

class SlugsListener
{
    /**
     * @var DefaultCommandBus
     */
    private $commandBus;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param ValidationCommandBus $commandBus
     */
    public function __construct(DefaultCommandBus $commandBus, RoleRepositoryInterface $roleRepository)
    {
        $this->commandBus = $commandBus;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Whenever a role is created, let's create a unique slug for it.
     *
     * @param RoleWasCreated $event
     */
    public function whenRoleWasCreated(RoleWasCreated $event)
    {
        $command = new CreateSlugCommand($event->role->id, $event->role, $this->roleRepository);

        $this->commandBus->execute($command);
    }
}
