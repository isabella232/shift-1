<?php

namespace Tectonic\Shift\Library\Filters;

use Illuminate\Support\Facades\Redirect;
use Tectonic\Shift\Controllers\InstallationController;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

/**
 * Class AccountFilter
 *
 * The account filter merely looks at the current domain request, and finds the account based on that domain.
 *
 * If no domain can be found, then a 404 is thrown.
 *
 * @package Tectonic\Shift\Library\Filters
 */
class AccountFilter
{
	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountsService
	 */
	private $currentAccountService;

	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountManagementService
	 */
	private $accountManagementService;

	/**
	 * @param CurrentAccountService $currentAccountService
	 * @param AccountManagementService $accountManagementService
	 */
	public function __construct(CurrentAccountService $currentAccountService, AccountManagementService $accountManagementService)
	{
		$this->currentAccountService = $currentAccountService;
		$this->accountManagementService = $accountManagementService;
	}

	/**
	 * The following filter simply retrieves the current account based on the request information
     * and then sets this value for future retrieval. If no account can be found for the request,
     * then two things need to happen:
     *
     * 1. Check to see if ANY accounts have been configured if no accounts exist then
     * 2. Ask the user if they'd like to setup the default (first) account. This is required
     *    for new installations.
     * 3. If an account does exist but does not match the domain, then we throw an account
     *    not found exception and deal with that later.
	 */
	public function filter()
	{
		$account = $this->currentAccountService->determineCurrentAccount();

		if (!$account) {
            $count = $this->accountManagementService->totalNumberOfAccounts();

            if ($count === 0) {
                return Redirect::action(InstallationController::class.'@getInstall');
            }
		}

		$this->currentAccountService->setCurrentAccount($account);
	}
}
