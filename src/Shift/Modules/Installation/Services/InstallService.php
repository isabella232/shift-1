<?php
namespace Tectonic\Shift\Modules\Installation\Services;

use Event;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Installation\Commands\InstallShiftCommand;
use Tectonic\Shift\Modules\Installation\Contracts\InstallationObserverInterface;

class InstallService
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
     * Called on a new installation of Shift. Validates the input provided
     *
     * @param array $input
     * @param InstallationObserverInterface $listener
     * @return mixed
     */
    public function freshInstall(array $input = [], InstallationObserverInterface $listener)
    {
        $command = new InstallShiftCommand($input['name'], $input['host'], $input['language'], $input['email'], $input['password']);

        try {
            $this->commandBus->execute($command);
        }
        catch (ValidationException $exception) {
            return $listener->onValidationFailure($exception);
        }
        catch (Exception $exception) {
            return $listener->failure($exception);
        }

        return $listener->onSuccess();
    }
}
