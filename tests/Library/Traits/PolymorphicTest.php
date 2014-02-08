<?php

use Mockery as m;
use Tests\Stubs\PolymorphicStub;
use Tests\Stubs\PolymorpherStub;

class PolymorphicTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->polymorpher = new PolymorphicStub;
	}

	/**
     * @expectedException BadMethodCallException
     */
	public function testNoMethodsAvailableShouldThrowException()
	{
		$this->polymorpher->someMethod();
	}

	public function testRegisteringANewObjectShouldRespondToPolymorphicCalls()
	{
		PolymorphicStub::registerPolymorphic(new PolymorpherStub);

		$this->assertEquals('this result', $this->polymorpher->example());
	}
}
