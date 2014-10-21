<?php
namespace Tectonic\Shift\Modules\Accounts\Services;

use Event;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserInterface;

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
     * @param AccountInterface $account
     * @param UserInterface $user
     * @returns Account
     */
    public function transferOwnership(AccountInterface $account, UserInterface $user)
    {
        $account->setOwner($user);

        $this->accountRepository->save($account);

        Event::fire('account.new-owner', [$account, $user]);
    }

    /**
     * Adds a new user to an account.
     *
     * @param AccountInterface $account
     * @param UserInterface $user
     */
    public function addUser(AccountInterface $account, UserInterface $user)
    {
        $this->accountRepository->addUser($account, $user);

        Event::fire('account.user-added', [$account, $user]);
    }
}
