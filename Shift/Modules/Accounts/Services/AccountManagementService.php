<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

/**
 * Class AccountsService
 *
 * The accounts service provides some methods for working with accounts and eases the use of working with
 * 1 or more accounts when logged in as an authenticated consumer that has access to those accounts.
 *
 * @package Tectonic\Shift\Modules\Accounts\Services
 */

class AccountManagementService extends ManagementService
{
	/**
	 * @param AccountRepositoryInterface $repository
	 */
	public function __construct(AccountRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Find a domain that has been registered with the system.
	 *
	 * @param $domain
	 * @return Account
	 */
	public function getAccountForDomain($domain)
	{
		return $this->repository->requireByDomain($domain);
	}
}
