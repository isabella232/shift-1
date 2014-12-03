<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Auth\AuthManager;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

class AuthenticateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authenticate;

    /**
     * @param \Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface $userRepo
     * @param \Illuminate\Auth\AuthManager                                    $authenticate
     */
    public function __construct(UserRepositoryInterface $userRepo, AuthManager $authenticate)
    {
        $this->userRepo = $userRepo;
        $this->authenticate = $authenticate;
    }

    /**
     * Handle the command.
     *
     * @param $command
     *
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException
     * @throws \Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function handle($command)
    {
        // First check to see if the users credentials are valid.
        $userCredentialsAreValid = $this->authenticate->validate(['email' => $command->email, 'password' => $command->password]);

        // If user credential are invalid, throw exception.
        if(!$userCredentialsAreValid) throw new InvalidAuthenticationCredentialsException();

        // Find out if user has an account id with the current account
        $accountUser = $this->userRepo->getByEmailAndAccount($command->email, CurrentAccount::get());

        // If an account user is found, login and return user
        if($accountUser)
        {
            $this->authenticate->login($accountUser, $command->remember);

            return $this->authenticate->getUser();
        }

        // Login failed, throw exception
        throw new UserAccountAssociationException();
    }
}