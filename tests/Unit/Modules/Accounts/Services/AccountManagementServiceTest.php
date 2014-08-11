<?php

namespace Tests\Unit\Modules\Accounts\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tests\TestCase;

class AccountManagementServiceTest  extends TestCase
{
	private $mockRepository;
	private $service;

	public function setUp()
	{
		parent::setUp();

		$this->mockRepository  = m::mock('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface');

		$this->service  = new AccountManagementService($this->mockRepository);
	}

	public function testRequestedDomain()
	{
		$this->mockRepository->shouldReceive('requireByDomain')->with('whatever')->andReturn('account');

		$this->assertEquals('account', $this->service->getRequestedDomain('whatever'));
	}
}
