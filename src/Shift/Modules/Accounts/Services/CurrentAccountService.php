<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Request;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

/**
 * Class CurrentAccountService
 *
 * This service manages the functionality surrounding the current account for the request. Accounts
 * are determined based on the domain name of the request. There are some special use-cases for when
 * an account does not exist, and also some edge cases where managers of accounts can log into a separate
 * account as another user.
 *
 * All of this functionality is managed by the current account service.
 *
 * @author Kirk Bushell
 * @package Tectonic\Shift\Modules\Accounts\Services
 */
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

	/**
	 * @param AccountRepositoryInterface $accountRepository
	 */
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