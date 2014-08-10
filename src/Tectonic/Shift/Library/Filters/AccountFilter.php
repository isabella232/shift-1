<?php

namespace Tectonic\Shift\Library\Filters;
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
	private $service;

	/**
	 * @param AccountsService $service
	 */
	public function __construct(AccountsService $service)
	{
		$this->service = $service;
	}

	/**
	 * @param $route
	 * @param $request
	 */
	public function filter($route, $request)
	{
		$account = $this->service->getRequestedDomain($request->server('SERVER_NAME'));

		$this->service->setRequestedDomain($account);
	}
}
