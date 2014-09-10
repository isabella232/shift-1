<?php

namespace Tests\Unit\Library\Support\Database\Doctrine;

use EntityManager;
use Mockery as m;
use Tests\Stubs\DoctrineRepositoryStub;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    private $mockEntityManager;

    public function setUp()
    {
        $this->mockEntityManager = new EntityManager;
        $this->repository = new DoctrineRepositoryStub($this->mockEntityManager);
    }

    public function testField()
    {
        $this->assertEquals('t.field', $this->repository->field('field'));
    }

    public function testRetrievalById()
    {
	    EntityManager::shouldReceive('getResult')->andReturn('found record');

        $this->assertEquals('found record', $this->repository->getById(1));
    }
} 