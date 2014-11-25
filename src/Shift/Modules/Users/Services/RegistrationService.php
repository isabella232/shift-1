<?php
namespace Tectonic\Shift\Modules\Users\Services;

use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;

class RegistrationService
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
     * Register a new user via the RegisterUserCommand, and manage any errors that may occur.
     *
     * @param array $input
     * @param RegistrationListenerInterface $registrationListener
     */
    public function registerUser(array $input = [], RegistrationListenerInterface $registrationListener)
    {
        try {
            $command = new RegisterUserCommand(
                $input['firstName'],
                $input['lastName'],
                $input['email'],
                $input['password'],
                $input['password_confirmation']
            );

            $user = $this->commandBus->execute($command);

            return $registrationListener->onSuccess($user);
        }
        catch (ValidationException $e) {
            return $registrationListener->onValidationError($e);
        }
    }
}
 