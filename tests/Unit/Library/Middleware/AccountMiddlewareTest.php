<?php
namespace Tests\Unit\Library\Middleware;

use CurrentAccount;
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
	private $middleware;

	public function setUp()
	{
		parent::setUp();

        $this->mockAccount = m::mock(Account::class);
		$this->mockAccountManagementService = m::mock(AccountsService::class)->makePartial();

		$this->middleware = new AccountMiddleware($this->mockAccountManagementService);
	}

	public function testFilterWithNoActiveAccount()
	{
		CurrentAccount::shouldReceive('determine')->once()->andReturn(null);
		$this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

        $this->middleware->filter();
	}

    public function testFilterWithActiveValidAccount()
    {
        CurrentAccount::shouldReceive('determine')->once()->andReturn($this->mockAccount);
        CurrentAccount::shouldReceive('set')->once()->with($this->mockAccount);

        $this->middleware->filter();
    }
}
