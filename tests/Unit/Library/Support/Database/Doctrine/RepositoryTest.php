<?php

namespace Tests\Unit\Library\Support\Database\Doctrine;

use Doctrine\ORM\EntityManager;
use Mockery as m;
use Tests\Stubs\DoctrineRepositoryStub;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    private $mockEntityManager,
			$mockQueryBuilder;

    public function setUp()
    {
	    parent::setUp();

        $this->mockEntityManager = m::mock(EntityManager::class);
        $this->mockQueryBuilder = m::mock('queryBuilder');

        $this->repository = new DoctrineRepositoryStub($this->mockEntityManager);
    }

    public function testField()
    {
        $this->assertEquals('d.field', $this->repository->field('field'));
    }

    public function testRetrievalById()
    {
	    $this->mockEntityManager->shouldReceive('createQueryBuilder')->once()->andReturn($this->mockQueryBuilder);

	    $mockQueryObject = m::mock('query');

	    $this->mockQueryBuilder->shouldReceive('select')->once()->with('d');
	    $this->mockQueryBuilder->shouldReceive('from')->once()->with('Tests\Stubs\DoctrineEntityStub', 'd');
	    $this->mockQueryBuilder->shouldReceive('where')->once();
	    $this->mockQueryBuilder->shouldReceive('setParameter')->twice();
	    $this->mockQueryBuilder->shouldReceive('andWhere')->once()->with('d.id = :id');
	    $this->mockQueryBuilder->shouldReceive('getQuery')->once()->andReturn($mockQueryObject);

	    $mockQueryObject->shouldReceive('getResult')->andReturn(['found record']);

        $this->assertEquals('found record', $this->repository->getById(1));
    }
} 