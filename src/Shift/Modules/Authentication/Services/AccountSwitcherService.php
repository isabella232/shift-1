<?php namespace Tectonic\Shift\Modules\Authentication\Services;

use Illuminate\Support\Facades\Auth;
use Tectonic\Application\Commanding\DefaultCommandBus;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchAccountCommand;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchToAccountCommand;
use Tectonic\Shift\Modules\Authentication\Contracts\SwitchAccountResponderInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\AccountSwitchTokenNotFoundException;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;
use Tectonic\Shift\Modules\Authentication\Contracts\AccountSwitcherResponderInterface;

class AccountSwitcherService
{
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var \Tectonic\Application\Commanding\DefaultCommandBus
     */
    protected $commandBus;

    /**
     * @param \Tectonic\Application\Commanding\DefaultCommandBus                       $commandBus
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface $userRepository
     */
    public function __construct(DefaultCommandBus $commandBus, UserRepositoryInterface $userRepository)
    {
        $this->commandBus     = $commandBus;
        $this->userRepository = $userRepository;
    }

    /**
     * Get a list of account a user belongs to.
     *
     * @param $input
     *
     * @return mixed
     */
    public function getUserAccounts($input)
    {
        $queryString = array_key_exists('q', $input) ? $input['q'] : null;

        return $this->userRepository->getAccounts(Auth::user(), $queryString);
    }

    /**
     * Handle switching user to another account
     *
     * @param int                                                                                $accountId
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\AccountSwitcherResponderInterface $responder
     *
     * @return mixed
     */
    public function switchToAccount($accountId, AccountSwitcherResponderInterface $responder)
    {
        try {
            $command = new SwitchToAccountCommand($accountId, Auth::user()->id);

            $redirectUrl = $this->commandBus->execute($command);

            return $responder->onSuccess($redirectUrl);

        } catch (UserAccountAssociationException $e) {
            return $responder->onFailure();
        }
    }

    /**
     * Handle switching in to a different account
     *
     * @param string                                                                           $token
     * @param \Tectonic\Shift\Modules\Authentication\Contracts\SwitchAccountResponderInterface $responder
     *
     * @return mixed
     */
    public function switchAccount($token, SwitchAccountResponderInterface $responder)
    {
        try {
            $command = new SwitchAccountCommand($token);

            $this->commandBus->execute($command);

            return $responder->onSuccess();

        } catch (AccountSwitchTokenNotFoundException $e) {
            return $responder->onFailure();
        }
    }
}