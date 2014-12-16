<?php
namespace Tests\Unit\Library\Authorization;

use Tectonic\Shift\Library\Authorization\ConsumerType;
use Tests\UnitTestCase;

class ConsumerTypeTest extends UnitTestCase
{
	public function testObjectType()
    {
        $consumerType = new ConsumerType('user');

        $this->assertInstanceOf(ConsumerType::class, $consumerType);
    }

    public function testTypeInvalidity()
    {
        $this->setExpectedException('Assert\AssertionFailedException');

        new ConsumerType('invalid');
    }

    public function testTypeValidity()
    {
        $consumerUserType = new ConsumerType('user');
        $consumerApiType = new ConsumerType('api');

        $this->assertEquals('user', $consumerUserType);
        $this->assertEquals('api', $consumerApiType);
    }
}
