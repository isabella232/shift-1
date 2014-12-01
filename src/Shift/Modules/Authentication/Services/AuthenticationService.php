<?php
namespace Tectonic\Shift\Modules\Authentication\Services;

use Illuminate\Auth\UserInterface;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Authentication\Commands\AuthenticateUserCommand;
use Tectonic\Shift\Modules\Authentication\Commands\LogoutUserCommand;
use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;
use Tectonic\Shift\Modules\Authentication\Contracts\LogoutResponderInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;

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
        } catch(UserAccountAssociationException $e) {
            return $responder->onUserAccountFailure($e);
        }
    }

    /**
     * Attempt logout for current user.
     *
     * @param \Illuminate\Auth\UserInterface                                            $user
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\LogoutResponderInterface $responder
     *
     * @return mixed
     */
    public function logout(UserInterface $user, LogoutResponderInterface $responder)
    {
        $command = new LogoutUserCommand($user);

        $this->commandBus->execute($command);

        return $responder->onSuccess($user);
    }
}