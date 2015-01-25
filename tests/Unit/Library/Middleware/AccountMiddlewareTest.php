<?php
namespace Tests\Unit\Library\Middleware;

use CurrentAccount;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;
use Mockery as m;
use Tectonic\Shift\Library\Middleware\AccountMiddleware;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tests\UnitTestCase;

class AccountMiddlewareTest extends UnitTestCase
{
    private $mockAccount;
	private $mockAccountManagementService;
	private $mockGuard;
	private $middleware;

	public function setUp()
	{
		parent::setUp();

		$this->mockGuard = m::mock(Guard::class);
        $this->mockAccount = m::mock(Account::class);
		$this->mockAccountManagementService = m::mock(AccountsService::class)->makePartial();

		$this->middleware = new AccountMiddleware($this->mockGuard, $this->mockAccountManagementService);
	}

	public function testFilterWithNoActiveAccount()
	{
		$mockRequest = m::spy('requestor');

		CurrentAccount::shouldReceive('determine')->once()->andReturn(null);

		$this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

		Redirect::shouldReceive('route')->with('install')->once();

        $this->middleware->handle($mockRequest, function() {});
	}

    public function testFilterWithActiveValidAccount()
    {
	    $mockRequest = m::spy('requestor');

        CurrentAccount::shouldReceive('determine')->once()->andReturn($this->mockAccount);
        CurrentAccount::shouldReceive('set')->once()->with($this->mockAccount);

        $this->middleware->handle($mockRequest, function() {});
    }
}
