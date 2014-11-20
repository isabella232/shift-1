<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Event;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Users\Models\User;

class AccountUsersService
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->accountRepository = $repository;
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

        Event::fire('account.new-owner', [$account, $user]);
    }

    /**
     * Adds a new user to an account.
     *
     * @param Account $account
     * @param User $user
     */
    public function addUser(Account $account, User $user)
    {
        $this->accountRepository->addUser($account, $user);

        Event::fire('account.user-added', [$account, $user]);
    }
}
