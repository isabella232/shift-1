<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Tectonic\Application\Validation\ValidationCommandBus;

class RoleService
{
    /**
     * @var ValidationCommandBus
     */
    private $commandBus;

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
        $command = new CreateRoleCommand($input['name']);

        $this->commandBus->execute($command);
    }
}
 