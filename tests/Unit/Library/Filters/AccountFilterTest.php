<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\AccountFilter;
use Tests\UnitTestCase;

class AccountFilterTest extends UnitTestCase
{
	private $mockCurrentAccountService;
	private $mockAccountManagementService;
	private $mockRequest;

	public function setUp()
	{
		parent::setUp();

		$this->mockCurrentAccountService = m::mock('Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService');
		$this->mockAccountManagementService = m::mock('Tectonic\Shift\Modules\Accounts\Services\AccountManagementService');
		$this->mockRequest = m::mock('whatever');

		$this->filter = new AccountFilter($this->mockCurrentAccountService, $this->mockAccountManagementService);
	}

	public function testFilterShouldDeferToUtilityClass()
	{
		$domain = 'www.somedomain.com';

        // The line below allows use to not receive errors when having custom __call() methods
        if(defined('E_STRICT')) error_reporting('E_ALL ^ E_STRICT');

		$mockAccount = m::mock('Tectonic\Shift\Modules\Accounts\Entities\Account');

		$this->mockRequest->shouldReceive('server')->with('SERVER_NAME')->andReturn($domain);
		$this->mockAccountManagementService->shouldReceive('getRequestedDomain')->with($domain)->andReturn($mockAccount);
		$this->mockCurrentAccountService->shouldReceive('determineCurrentAccount')->once()->andReturn('account');
		$this->mockCurrentAccountService->shouldReceive('setCurrentAccount')->once()->with('account');

		$this->filter->filter(null, $this->mockRequest);
	}
}
