<?php

namespace Tectonic\Shift\Library\Filters;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;

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
	private $accountsService;

	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountManagementService
	 */
	private $accountManagementService;

	/**
	 * @param AccountsService $accountsService
	 * @param AccountManagementService $accountManagementService
	 */
	public function __construct(AccountsService $accountsService, AccountManagementService $accountManagementService)
	{
		$this->accountsService = $accountsService;
		$this->accountManagementService = $accountManagementService;
	}

	/**
	 * @param $route
	 * @param $request
	 */
	public function filter($route, $request)
	{
		$account = $this->accountManagementService->getRequestedDomain($request->server('SERVER_NAME'));

		$this->accountsService->setCurrentAccount($account);
	}
}
