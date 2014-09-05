<?php

namespace Tests\Unit\Library\Support\Database\Doctrine;

use Doctrine\ORM\EntityManager;
use Mockery as m;
use Tests\Stubs\DoctrineRepositoryStub;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    private $mockEntityManager;

    public function setUp()
    {
        $this->mockEntityManager = m::mock(EntityManager::class)->makePartial();
        $this->repository = new DoctrineRepositoryStub($this->mockEntityManager);
    }

    public function testField()
    {
        $this->assertEquals('d.field', $this->repository->field('field'));
    }
} 