<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Support\BaseManagementService;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

/**
 * Class AccountsService
 *
 * The accounts service provides some methods for working with accounts and eases the use of working with
 * 1 or more accounts when logged in as an authenticated consumer that has access to those accounts.
 *
 * @package Tectonic\Shift\Modules\Accounts\Services
 */
class AccountManagementService extends BaseManagementService
{
	/**
	 * @param AccountRepositoryInterface $repository
	 */
	public function __construct(AccountRepositoryInterface $repository)
	{
		$this->repository = $repository;
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
