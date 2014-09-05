<?php

namespace Tests\Unit\Library\Support\Database\Doctrine;

use Tests\Stubs\DoctrineEntityStub;
use Tests\TestCase;

class EntityTest extends TestCase
{
    public function testMagicGetterAndSetterCalls()
    {
        $entity = new DoctrineEntityStub;

        $entity->setSomeThing('value');

        $this->assertEquals('value', $entity->getSomeThing());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testBadMethodCall()
    {
        $entity = new DoctrineEntityStub;
        $entity->setMissingPropertyMethod('something');
    }
} 