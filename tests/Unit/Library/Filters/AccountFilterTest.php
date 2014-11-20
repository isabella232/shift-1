<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\AccountFilter;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tests\UnitTestCase;

class AccountFilterTest extends UnitTestCase
{
    private $mockAccount;
	private $mockAccountManagementService;
	private $mockCurrentAccountService;

    public function setUp()
	{
		parent::setUp();

        $this->mockAccount = m::mock(Account::class);
		$this->mockCurrentAccountService = m::mock(CurrentAccountService::class);
		$this->mockAccountManagementService = m::mock(AccountManagementService::class)->makePartial();

		$this->filter = new AccountFilter($this->mockCurrentAccountService, $this->mockAccountManagementService);
	}

	public function testFilterWithNoActiveAccount()
	{
		$this->mockCurrentAccountService->shouldReceive('determine')->once()->andReturn(null);
		$this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

        $this->filter->filter();
	}

    public function testFilterWithActiveValidAccount()
    {
        $this->mockCurrentAccountService->shouldReceive('determine')->once()->andReturn($this->mockAccount);
        $this->mockCurrentAccountService->shouldReceive('set')->once()->with($this->mockAccount);

        $this->filter->filter();
    }
}
