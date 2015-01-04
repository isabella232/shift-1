<?php
namespace Tests\Unit\Modules\Accounts\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidation;
use Tests\UnitTestCase;

class AccountManagementServiceTest  extends UnitTestCase
{
	private $mockRepository;
	private $service;

	public function init()
	{
		$this->mockRepository = m::mock(AccountRepositoryInterface::class);
		$this->service = new AccountsService($this->mockRepository, new AccountValidation);
	}

	public function testRequestedDomain()
	{
        $this->mockRepository->shouldReceive('requireByDomain')->with('whatever')->once()->andReturn('account');

        $this->assertEquals('account', $this->service->getAccountForDomain('whatever'));
	}

	public function testNumberOfAccounts()
	{
		$this->mockRepository->shouldReceive('getCount')->once()->andReturn(1);

		$this->assertEquals(1, $this->service->totalNumberOfAccounts('whatever'));
	}
}
