<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Illuminate\Auth\AuthManager;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Application\Eventing\EventGenerator;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Authentication\Events\UserHasAuthenticated;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

class AuthenticateUserCommandHandler implements CommandHandlerInterface
{
    use EventGenerator;
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authenticate;

    /**
     * @var \Tectonic\Application\Eventing\EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface $userRepo
     * @param \Illuminate\Auth\AuthManager                                             $authenticate
     * @param \Tectonic\Application\Eventing\EventDispatcher                           $eventDispatcher
     */
    public function __construct(UserRepositoryInterface $userRepo, AuthManager $authenticate, EventDispatcher $eventDispatcher)
    {
        $this->userRepo = $userRepo;
        $this->authenticate = $authenticate;
        $this->eventDispatcher = $eventDispatcher;
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

            $user = $this->authenticate->getUser();

            // Raise an event, and dispatch
            $this->raise(new UserHasAuthenticated($user));
            $this->eventDispatcher->dispatch($this->releaseEvents());

            return $user;
        }

        // Login failed, throw exception
        throw new UserAccountAssociationException();
    }
}