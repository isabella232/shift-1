<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;

class CreateRoleCommandHandler implements CommandHandlerInterface
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    function __construct(RoleRepositoryInterface $roleRepository, EventDispatcher $eventDispatcher)
    {
        $this->roleRepository = $roleRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $role = Role::create($attributes = []);

        $this->roleRepository->save($role);

        $this->eventDispatcher->dispatch($role->releaseEvents());
    }
}
 