<?php

namespace Tectonic\Shift\Modules\Accounts\Services;

use Event;
use Tectonic\Shift\Library\Support\ManagementService;
use Tectonic\Shift\Modules\Accounts\Entities\Account;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidation;
use Tectonic\Shift\Modules\Users\Entities\User;

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
	public function __construct(AccountRepositoryInterface $repository, AccountValidation $validator)
	{
		$this->repository = $repository;
        $this->createValidator = $validator;
        $this->updateValidator = $validator;
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

    /**
     * Get the total number of accounts setup for this installation.
     *
     * @return integer
     */
    public function totalNumberOfAccounts()
    {
        return $this->repository->getCount();
    }
}
