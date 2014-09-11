<?php

namespace Tests\Unit\Modules\Accounts\Repositories;

use Doctrine\ORM\EntityManager;
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

		$this->mockEntityManager = m::mock(EntityManager::class);
		$this->repository = new DoctrineAccountRepository($this->mockEntityManager);
	}

    public function testQueryingForDomain()
    {
	    $domain = 'www.somedomain.com';

        $this->mockEntityManager->shouldReceive('createQuery')->once()->andReturn($this->mockEntityManager);
        $this->mockEntityManager->shouldReceive('select')->once()->andReturn($this->mockEntityManager);
        $this->mockEntityManager->shouldReceive('join')->once()->andReturn($this->mockEntityManager);
        $this->mockEntityManager->shouldReceive('where')->once()->with('domains.domain = \':domain\'')->andReturn($this->mockEntityManager);
        $this->mockEntityManager->shouldReceive('setParameter')->once()->with('domain', $domain)->andReturn($this->mockEntityManager);
	    $this->mockEntityManager->shouldReceive('getSingleResult')->once()->andReturn('account');

        $this->assertEquals('account', $this->repository->requireByDomain($domain));
    }
}
