<?php

namespace Tests\Unit\Modules\Accounts\Repositories;

use Doctrine\ORM\EntityManager;
use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Modules\Accounts\AccountNotFoundException;
use Tectonic\Shift\Modules\Accounts\Repositories\DoctrineAccountRepository;

class DoctrineAccountRepositoryTest extends TestCase
{
	private $repository;
	private $mockEntityManager;

	public function setUp()
	{
		parent::setUp();

		$this->mockEntityManager = m::mock(EntityManager::class);
		$this->mockQuery = m::mock('query');
		$this->repository = new DoctrineAccountRepository($this->mockEntityManager);
	}

    public function testGetByDomain()
    {
	    $domain = 'www.somedomain.com';

	    $this->setupDomainQuery($domain);
	    $this->mockQuery->shouldReceive('getResult')->once()->andReturn('account');

        $this->assertEquals('account', $this->repository->getByDomain($domain));
    }

	public function testRequireByDomain()
	{
		$domain = 'www.somedomain.com';

		$this->setupDomainQuery($domain);
		$this->mockQuery->shouldReceive('getResult')->once()->andReturn([]);

		$this->setExpectedException(AccountNotFoundException::class);

		$this->assertEquals('account', $this->repository->requireByDomain($domain));
	}

	private function setupDomainQuery($domain)
	{
		$this->mockEntityManager->shouldReceive('createQueryBuilder')->once()->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('select')->once()->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('from')->once()->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('join')->once()->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('where')->once()->with('d.domain = :domain')->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('setParameter')->once()->with('domain', $domain)->andReturn($this->mockEntityManager);
		$this->mockEntityManager->shouldReceive('getQuery')->once()->andReturn($this->mockQuery);
	}
}
