<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Auth\AuthManager;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

class AuthenticateUserCommandHandler implements CommandHandlerInterface
{

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authenticate;

    /**
     * @param \Illuminate\Auth\AuthManager $authenticate
     */
    public function __construct(AuthManager $authenticate)
    {
        $this->authenticate = $authenticate;
    }

    /**
     * Handle the command.
     *
     * @param $command
     *
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function handle($command)
    {
        $credentials = ['email' => $command->email, 'password' => $command->password];

        if($this->authenticate->attempt($credentials, $command->remember)) {
            return $this->authenticate->getUser();
        }

        throw new InvalidAuthenticationCredentialsException();
    }
}