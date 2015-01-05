<?php
namespace Tests\Unit\Library\Authorization;

use Illuminate\Support\Collection;
use Mockery as m;
use Tectonic\Shift\Library\Authorization\ConsumerInterface;
use Tectonic\Shift\Library\Authorization\ConsumerManager;
use Tectonic\Shift\Library\Authorization\ConsumerType;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;

class ConsumerManagerTest extends \Tests\UnitTestCase
{
	private $consumerManager;

	public function init()
	{
		$this->consumerManager = new ConsumerManager;
	}

	public function testConsumerSetAndRetrieval()
	{
		$userConsumer = m::mock(ConsumerInterface::class);

		$this->consumerManager->set($userConsumer);

		$this->assertEquals($userConsumer, $this->consumerManager->get());
	}

	public function testGuestCheck()
	{
		$this->assertTrue($this->consumerManager->guest());

		$userConsumer = m::mock(ConsumerInterface::class);

		$this->consumerManager->set($userConsumer);

		$this->assertFalse($this->consumerManager->guest());
	}

	public function testGuestLanguage()
	{
		$mockAccount = m::mock('account');
		$mockAccount->shouldReceive('defaultLanguage')->andReturn('code');

		CurrentAccount::shouldReceive('get')->andReturn($mockAccount);

		$this->assertEquals('code', $this->consumerManager->language());
	}

	public function testAuthorisedConsumerLanguage()
	{
		$userConsumer = m::spy(ConsumerInterface::class);

		$this->consumerManager->set($userConsumer);
		$this->consumerManager->language();

		$userConsumer->shouldhaveReceived('language');
	}

	public function testTypes()
	{
		$this->assertEquals($this->consumerManager->type(), new ConsumerType('guest'));

		$userConsumer = m::mock(ConsumerInterface::class);
		$userConsumer->shouldReceive('type')->once()->andReturn(new ConsumerType('user'));

		$this->consumerManager->set($userConsumer);

		$this->assertEquals($this->consumerManager->type(), new ConsumerType('user'));
	}
}
