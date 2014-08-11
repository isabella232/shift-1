<?php namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\AccountFilter;
use Tests\TestCase;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;

class AccountFilterTest extends TestCase
{
	private $mockAccountsService;
	private $mockAccountManagementService;
	private $mockRequest;

	public function setUp()
	{
		parent::setUp();

		$this->mockAccountsService = m::mock('Tectonic\Shift\Modules\Accounts\Services\AccountsService');
		$this->mockAccountManagementService = m::mock('Tectonic\Shift\Modules\Accounts\Services\AccountManagementService');
		$this->mockRequest = m::mock('whatever');

		$this->filter = new AccountFilter($this->mockAccountsService, $this->mockAccountManagementService);
	}

	public function testFilterShouldDeferToUtilityClass()
	{
		$domain = 'www.somedomain.com';

		$mockAccount = m::mock('Tectonic\Shift\Modules\Accounts\Models\Account');

		$this->mockRequest->shouldReceive('server')->with('SERVER_NAME')->andReturn($domain);
		$this->mockAccountManagementService->shouldReceive('getRequestedDomain')->with($domain)->andReturn($mockAccount);
		$this->mockAccountsService->shouldReceive('setCurrentAccount')->with($mockAccount);

		$this->filter->filter(null, $this->mockRequest);
	}
}
