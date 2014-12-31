<?php
namespace Tectonic\Shift\Library\Filters;

use App;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;

class InstallationFilter
{
	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountManagementService
	 */
	private $accountManagementService;

	/**
	 * @param AccountManagementService $accountManagementService
	 */
	public function __construct(AccountManagementService $accountManagementService)
	{
		$this->accountManagementService = $accountManagementService;
	}

	/**
	 * Check to see if ANY accounts have been setup. If they have, return a 404. This
     * should be used for requests that are only active when no accounts are available.
	 */
	public function filter()
	{
		if ($this->accountManagementService->totalNumberOfAccounts()) {
            App::abort(404);
        }
	}
}
