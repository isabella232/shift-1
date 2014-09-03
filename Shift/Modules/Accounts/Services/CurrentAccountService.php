<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

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

    public function getCurrentAccount()
    {
        return $this->account;
    }

    public function setCurrentAccount(Account $account)
    {
        $this->account = $account;
    }

    public function determineCurrentAccount()
    {
        $domain = Request::getHttpHost();
    }
} 