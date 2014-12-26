<?php
namespace Tectonic\Shift\Modules\Identity\Roles\Services;

use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Library\Support\DefaultResponder;
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
    public function create(array $input, DefaultResponder $responder)
    {
        try {
            $command = new CreateRoleCommand($input['translated']);

            $this->commandBus->execute($command);
        }
        catch (ValidationException $e) {
            return $responder->onValidationFailure($e);
        }
        catch (Exception $e) {
            return $responder->onFailure($e);
        }

        return $responder->onSuccess();
    }
}
