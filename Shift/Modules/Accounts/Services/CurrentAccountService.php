<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

class CurrentAccountService
{
    /**
     * @var \Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var Account
     */
    private $account;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Returns the currently active account for this request.
     *
     * @return Account
     */
    public function getCurrentAccount()
    {
        return $this->account;
    }

    /**
     * Set the account that is currently being used for this request.
     *
     * @param Account $account
     */
    public function setCurrentAccount(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Determines the account that is being used for the current request.
     *
     * @return Account
     */
    public function determineCurrentAccount()
    {
        $domain = Request::getHttpHost();

        return $this->accountRepository->requireByDomain($domain);
    }
} 