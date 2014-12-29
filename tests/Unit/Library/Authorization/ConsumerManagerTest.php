<?php
namespace Tests\Unit\Library\Authorization;

use Illuminate\Support\Collection;
use Mockery as m;
use Tectonic\Shift\Library\Authorization\ConsumerInterface;
use Tectonic\Shift\Library\Authorization\ConsumerManager;

class ConsumerManagerTest extends \Tests\UnitTestCase
{
	public function init()
	{
		$this->consumer = new ConsumerManager;
	}

	public function testConsumerSetAndRetrieval()
	{
		$userConsumer = m::mock(ConsumerInterface::class);

		$this->consumer->set($userConsumer);

		$this->assertEquals($userConsumer, $this->consumer->get());
	}
}
