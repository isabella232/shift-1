<?php namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tectonic\Shift\Library\Authorization\Consumer;
use Tectonic\Shift\Library\Authorization\AuthenticatedConsumer;

class AuthenticatedConsumerTest extends \PHPUnit_Framework_TestCase
{
	private $authenticatedConsumer;
	private $consumer;
	private $mockAuthority;

	public function setUp()
	{
		$this->consumer = new Consumer(1);
		$this->mockAuthority = m::mock('Authority\Authority');

		$this->authenticatedConsumer = new AuthenticatedConsumer($this->consumer, $this->mockAuthority);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testSetPermissions()
	{
		$permissions = [
			['allow' => true, 'resource' => 'User', 'rule' => 'read'],
			['deny' => true, 'resource' => 'User', 'rule' => 'write'],
			['allow' => false, 'resource' => 'User', 'rule' => 'update'],
			['deny' => false, 'resource' => 'User', 'rule' => 'create']
		];

		$this->mockAuthority->shouldReceive('allow')->with('read', 'User')->once();
		$this->mockAuthority->shouldReceive('allow')->with('create', 'User')->once();

		$this->authenticatedConsumer->setPermissions($permissions);
	}

	public function testGetConsumer()
	{
		$this->assertEquals($this->consumer, $this->authenticatedConsumer->getConsumer());
	}

	public function testGetAuthority()
	{
		$this->assertEquals($this->mockAuthority, $this->authenticatedConsumer->getAuthority());
	}

	public function testCan()
	{
		$this->mockAuthority->shouldReceive('can')->with('read', 'Resource')->andReturn(true);

		$this->assertEquals(true, $this->authenticatedConsumer->can('read', 'Resource'));
	}
}
