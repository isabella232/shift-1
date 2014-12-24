<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Shift\Modules\Identity\Roles\Commands\CreateRoleCommand;

class RoleService
{
    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

    /**
     * @param ValidationCommandBus $commandBus
     */
    public function __construct(ValidationCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Executes the command for creating a new role.
     *
     * @param array $input
     */
    public function create(array $input)
    {
        $command = new CreateRoleCommand($input['translated']['name']);

        $this->commandBus->execute($command);
    }
}
 