<?php

use Mockery as m;
use Tectonic\Shift\Library\Authorization\UserConsumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testConsumerConstruction()
	{
		$consumer = new UserConsumer(1);

		$this->assertEquals(1, $consumer->id);
	}
}
