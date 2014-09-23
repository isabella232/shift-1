<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

class AccountOwnershipService
{
    private $accountRepository;

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
        $account->userId = $user->getId();
        $account = $this->repository->update($account);

        Event::fire(class_basename($account).': ownership transferred', [$account]);
        Event::fire(class_basename($user).': new account owner', [$user]);

        return $account;
    }
}
