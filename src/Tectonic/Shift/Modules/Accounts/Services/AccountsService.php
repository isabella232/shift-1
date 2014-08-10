<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepository;

/**
 * Class AccountsService
 *
 * The accounts service provides some methods for working with accounts and eases the use of working with
 * 1 or more accounts when logged in as an authenticated consumer that has access to those accounts.
 *
 * @package Tectonic\Shift\Modules\Accounts\Services
 */
class AccountsService extends BaseManagementService
{
	/**
	 * @param AccountRepository $repository
	 */
	public function __construct(AccountRepository $repository)
	{
		$this->repository = $repository;
	}

    /**
     * Returns the account id for the currently authenticated user or 3rd party API token, and the
     * account that they are CURRENTLY working with. An authenticated consumer can have access to
     * numerous accounts, but will only work with one account at any given time.
     *
     * @todo Implement logic for 3rd party api token, as well as checks against the accounts the
     * user can actually manage.
     *
     * @return mixed
     */
    public function getCurrentAccountId()
    {
        $accounts = $this->getAccounts();
    }

    /**
     * Returns the accounts that an authenticated consumer has access to.
     *
     * @return array Account
     */
    public function getAccounts()
    {
        return $this->authenticatedConsumer->getAccounts();
    }

	/**
	 * Find a domain that has been registered with the system.
	 *
	 * @param $domain
	 * @return Account
	 */
	public function getRequestedDomain($domain)
	{
		return $this->repository->requireByDomain($domain);
	}
}
