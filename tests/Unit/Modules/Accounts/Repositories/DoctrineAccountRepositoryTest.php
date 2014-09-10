<?php

namespace Tests\Unit\Modules\Accounts\Repositories;

use EntityManager;
use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;

class DoctrineAccountRepositoryTest extends TestCase
{
	private $repository;
	private $mockEntityManager;

	public function setUp()
	{
		parent::setUp();

		$this->mockEntityManager = new EntityManager;
		$this->repository = new DoctrineAccountRepository($this->mockEntityManager);
	}

    public function testQueryingForDomain()
    {
	    $domain = 'www.somedomain.com';

        EntityManager::shouldReceive('findOneByDomain')
	        ->with($domain)->once()
	        ->andReturn('account');

        $this->assertEquals('account', $this->repository->requireByDomain($domain));
    }
}
