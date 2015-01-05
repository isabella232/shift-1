<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\LaravelLocalisation\Database\TranslationService;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;

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
     * @var TranslationService
     */
    private $translationService;

    /**
     * @var PermissionsService
     */
    private $permissionsService;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    function __construct(
        RoleRepositoryInterface $roleRepository,
        EventDispatcher $eventDispatcher,
        TranslationService $translationService,
        PermissionsService $permissionsService
    ) {
        $this->roleRepository = $roleRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->translationService = $translationService;
        $this->permissionsService = $permissionsService;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $role = Role::create(['default' => $command->default]);

        $this->roleRepository->save($role);

        $this->translationService->sync($role, $command->translated);
        $this->permissionsService->sync($role, $command->permissions);

        $this->eventDispatcher->dispatch($role->releaseEvents());
    }
}
