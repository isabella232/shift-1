<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\AccountFilter;
use Tests\TestCase;

class AccountFilterTest extends TestCase
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

		$mockAccount = m::mock('Tectonic\Shift\Modules\Accounts\Entities\Account');

		$this->mockRequest->shouldReceive('server')->with('SERVER_NAME')->andReturn($domain);
		$this->mockAccountManagementService->shouldReceive('getRequestedDomain')->with($domain)->andReturn($mockAccount);
		$this->mockCurrentAccountService->shouldReceive('determineCurrentAccount')->once();
		$this->mockCurrentAccountService->shouldReceive('setCurrentAccount')->with($mockAccount);

		$this->filter->filter(null, $this->mockRequest);
	}
}
