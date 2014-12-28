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
        $consumerGuestType = new ConsumerType('guest');

        $this->assertEquals('user', $consumerUserType);
        $this->assertEquals('api', $consumerApiType);
        $this->assertEquals('guest', $consumerGuestType);
    }

    public function testGuestCheck()
    {
        $consumerGuestType = new ConsumerType('guest');

        $this->assertTrue($consumerGuestType->guest());
        $this->assertFalse($consumerGuestType->user());
        $this->assertFalse($consumerGuestType->api());
    }

    public function testUserCheck()
    {
        $consumerUserType = new ConsumerType('user');

        $this->assertTrue($consumerUserType->user());
        $this->assertFalse($consumerUserType->guest());
        $this->assertFalse($consumerUserType->api());
    }

    public function testApiCheck()
    {
        $consumerApiType = new ConsumerType('api');

        $this->assertTrue($consumerApiType->api());
        $this->assertFalse($consumerApiType->user());
        $this->assertFalse($consumerApiType->guest());
    }
}
