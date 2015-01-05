<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\LaravelLocalisation\Database\TranslationService;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;

class UpdateRoleCommandHandler implements CommandHandlerInterface
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
     * @param EventDispatcher $eventDispatcher
     * @param TranslationService $translationService
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
        $role = $this->roleRepository->requireBySlug($command->slug);

        $role->update(['default' => $command->default]);

        $this->roleRepository->save($role);

        $this->permissionsService->sync($role, $command->permissions);
        $this->translationService->sync($role, $command->translated);

        $this->eventDispatcher->dispatch($role->releaseEvents());
    }
}
