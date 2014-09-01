<?php

namespace Tests\Unit\Modules\Accounts\Repositories;

use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;

class DoctrineAccountRepositoryTest extends TestCase
{
	private $mockModel;
	private $repository;

	public function setUp()
	{
		parent::setUp();

		$this->mockModel = m::mock('Tectonic\Shift\Modules\Accounts\Models\Account');
		$this->repository = new EloquentAccountRepository($this->mockModel);
	}

    public function testQueryingForValidDomain()
    {
	    $domain = 'www.somedomain.com';

        $this->mockModel->shouldReceive('whereHas')->once()->andReturn($this->mockModel);
        $this->mockModel->shouldReceive('first')->once()->andReturn('account');

        $this->assertEquals('account', $this->repository->requireByDomain($domain));
    }

	/**
	 * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function testQueryingForInvalidDomain()
	{
		$domain = 'www.somedomain.com';

		$this->mockModel->shouldReceive('whereHas')->once()->andReturn($this->mockModel);
		$this->mockModel->shouldReceive('first')->once()->andReturn(null);

		$this->repository->requireByDomain($domain);
	}
}
