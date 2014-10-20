<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Event;

use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Users\Entities\User;

class AccountOwnershipService
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
     * @param User $user
     * @returns Account
     */
    public function transfer(Account $account, User $user)
    {
        $account->setOwner($user);
        $account = $this->accountRepository->update($account);

        Event::fire(class_basename($account).': ownership transferred', [$account]);
        Event::fire(class_basename($user).': new account owner', [$user]);

        return $account;
    }
}
