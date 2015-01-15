<?php
namespace Tectonic\Shift\Library\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\App;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;

class InstallationMiddleware implements Middleware
{

	/**
	 * @var \Illuminate\Auth\Guard
	 */
	protected $auth;

	/**
	 * @var \Tectonic\Shift\Modules\Accounts\Services\AccountsService
	 */
	protected $accountService;

	/**
	 * @param \Illuminate\Auth\Guard $auth
	 * @param AccountsService        $accountService
	 */
	public function __construct(Guard $auth, AccountsService $accountService)
	{
		$this->auth = $auth;
		$this->accountService = $accountService;
	}

	/**
	 * Handle an incoming request.
	 *
	 * Check to see if ANY accounts have been setup. If they have, return a 404. This
     * should be used for requests that are only active when no accounts are available.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($this->accountService->totalNumberOfAccounts()) {
            App::abort(404);
        }

		return $next($request);
	}
}
