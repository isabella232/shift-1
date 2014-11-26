<?php
namespace Tectonic\Shift\Modules\Authentication\Services;

use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Authentication\Commands\AuthenticateUserCommand;
use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

class AuthenticationService
{

    /**
     * @var \Tectonic\Application\Validation\ValidationCommandBus
     */
    protected $commandBus;

    /**
     * @param \Tectonic\Application\Validation\ValidationCommandBus $commandBus
     */
    public function __construct(ValidationCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Attempt login
     *
     * @param array                                                                             $input
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface $responder
     *
     * @return mixed
     */
    public function login(array $input, AuthenticationResponderInterface $responder)
    {
        $remember = array_key_exists('remember', $input) ? $input['remember'] : false;

        try {
            $command = new AuthenticateUserCommand($input['email'], $input['password'], $remember);

            $authenticatedUser = $this->commandBus->execute($command);

            return $responder->onSuccess($authenticatedUser);

        } catch(ValidationException $e) {
            return $responder->onValidationFailure($e);
        } catch(InvalidAuthenticationCredentialsException $e) {
            return $responder->onAuthenticationFailure($e);
        }
    }
}