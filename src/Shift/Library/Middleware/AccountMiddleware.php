<?php
namespace Tectonic\Shift\Library\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Tectonic\Shift\Controllers\InstallationController;
use Tectonic\Shift\Modules\Accounts\AccountNotFoundException;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
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
class AccountMiddleware implements Middleware
{

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountsService
	 */
	protected $accountService;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard                                                    $auth
	 * @param \Tectonic\Shift\Modules\Accounts\Services\AccountsService $accountsService
	 */
	public function __construct(Guard $auth, AccountsService $accountsService)
	{
		$this->auth = $auth;
		$this->accountService = $accountsService;
	}

	/**
	 * Handle an incoming request.
	 *
	 * The following filter simply retrieves the current account based on the request information
	 * and then sets this value for future retrieval. If no account can be found for the request,
	 * then two things need to happen:
	 *
	 * 1. Check to see if ANY accounts have been configured if no accounts exist then
	 * 2. Ask the user if they'd like to setup the default (first) account. This is required
	 *    for new installations.
	 * 3. If an account does exist but does not match the domain, then we throw an account
	 *    not found exception and deal with that later.
	 *
	 * @throws AccountNotFoundException
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$account = CurrentAccount::determine($request->getHttpHost());

		if (!$account) {
			$count = $this->accountService->totalNumberOfAccounts();

			if ($count === 0) {
				return redirect()->route('install');
			}

			throw new AccountNotFoundException;
		}

		CurrentAccount::set($account);

		return $next($request);
	}

}
