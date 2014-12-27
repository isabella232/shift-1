<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;

class UpdateRolePermissionsCommandHandler implements CommandHandlerInterface
{
    /**
     * @var PermissionsService
     */
    private $permissionsService;

    /**
     * @param PermissionRepositoryInterface $permissionsRepository
     */
    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    /**
     * Handle the command.
     *
     * @param UpdateRolePermissionsCommand $command
     */
    public function handle($command)
    {
        $this->permissionsService->bulkUpdateFromInput($command->role, $command->permissions);
    }
}
