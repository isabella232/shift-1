<?php

namespace Tests\Unit\Modules\Accounts\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tests\TestCase;

class AccountsServiceTest  extends TestCase
{
	private $mockRepository;
	private $service;

	public function setUp()
	{
		parent::setUp();

		$this->mockRepository  = m::mock('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface');

		$this->service  = new AccountsService($this->mockRepository);
	}

	public function testRequestedDomain()
	{
		$this->mockRepository->shouldReceive('requireByDomain')->with('whatever');

		$this->service->getRequestedDomain('whatever');
	}
}
