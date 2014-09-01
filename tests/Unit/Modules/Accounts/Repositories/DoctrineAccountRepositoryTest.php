<?php

namespace Tests\Unit\Modules\Accounts\Repositories;

use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;
use Doctrine\ORM\EntityManager;

class DoctrineAccountRepositoryTest extends TestCase
{
	private $repository;
	private $mockEntityManager;

	public function setUp()
	{
		parent::setUp();

		$this->mockEntityManager = m::mock(EntityManager::class);
		$this->repository = new DoctrineAccountRepository($this->mockEntityManager);
	}

    public function testQueryingForDomain()
    {
	    $domain = 'www.somedomain.com';

        $this->mockEntityManager
	        ->shouldReceive('findOneByDomain')
	        ->once()->with($domain)
	        ->andReturn('account');

        $this->assertEquals('account', $this->repository->requireByDomain($domain));
    }
}
