<?php
namespace Tests\Unit\Modules\Accounts\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tectonic\Shift\Modules\Accounts\Validators\AccountValidation;
use Tests\TestCase;

class AccountManagementServiceTest  extends TestCase
{
	private $mockRepository;
	private $service;

	public function setUp()
	{
		parent::setUp();

		$this->mockRepository = m::spy(AccountRepositoryInterface::class);
		$this->service = new AccountManagementService($this->mockRepository, new AccountValidation);
	}

	public function testRequestedDomain()
	{
        $this->service->getAccountForDomain('whatever');

        $this->mockRepository->shouldHaveReceived('requireByDomain')->once();
	}
}
