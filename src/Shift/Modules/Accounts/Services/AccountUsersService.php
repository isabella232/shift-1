<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Event;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class AccountUsersService
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(EventDispatcher $dispatcher, AccountRepositoryInterface $repository)
    {
        $this->accountRepository = $repository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Transfers an account's ownership to another user.
     *
     * @param Account $account
     * @param UserInterface $user
     * @returns Account
     */
    public function transferOwnership(Account $account, User $user)
    {
        $account->setOwner($user);

        $this->accountRepository->save($account);

        $this->dispatcher->dispatch($account->releaseEvents());
    }

    /**
     * @param User $user
     */
    public function getLocaleFor(User $user)
    {

    }
}
