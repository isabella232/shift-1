<?php namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tests\TestCase;
use Tectonic\Shift\Library\Authorization\Bouncer;
use Tectonic\Shift\Library\Authorization\AuthenticatedConsumer;

class BouncerTest extends TestCase
{
	private $authenticatedConsumer;
	private $bouncer;
	private $mockAuthority;

	public function setUp()
	{
		parent::setUp();

		$mockConsumer = m::mock('Tectonic\Shift\Library\Authorization\ConsumerInterface');
		$this->mockAuthority = m::mock('Authority\Authority');

		$this->authenticatedConsumer = new AuthenticatedConsumer($mockConsumer, $this->mockAuthority);
		$this->bouncer = new Bouncer('User', $this->authenticatedConsumer);
	}

	public function testDetermineAction()
	{
		$this->assertEquals('update', $this->bouncer->determineAction('put'));
		$this->assertEquals('index', $this->bouncer->determineAction('delete'));
		$this->assertEquals('create', $this->bouncer->determineAction('post'));
		$this->assertEquals('view', $this->bouncer->determineAction('get'));
		$this->assertEquals('view', $this->bouncer->determineAction('whatever'));
	}

	public function testAddAccess()
	{
		$this->bouncer->addRequiredAccess('get', 'index', ['read']);
		$this->bouncer->addRequiredAccess('get', 'index', 'update');
		$this->bouncer->addRequiredAccess('get', 'other', 'any');
		$this->bouncer->addRequiredAccess('get', 'other', ['some', 'one']);
		$this->bouncer->addRequiredAccess('post', 'index', 'create');

		$matrix = $this->bouncer->getMatrix();

		$this->assertEquals(['index' => ['read', 'update'], 'other' => ['any', 'some', 'one']], $matrix['get']);
		$this->assertEquals(['index' => ['create']], $matrix['post']);
	}

	public function testDefaultAccess()
	{
		$this->bouncer->setupDefaultAccess();

		$matrix = $this->bouncer->getMatrix();

		$this->assertArrayHasKey('get', $matrix);
		$this->assertArrayHasKey('post', $matrix);
		$this->assertArrayHasKey('put', $matrix);
		$this->assertArrayHasKey('delete', $matrix);
	}

	public function testAuthorizeWithDefaults()
	{
		$this->bouncer->setupDefaultAccess();

		$this->mockAuthority->shouldReceive('can')->with('read', 'User')->andReturn(true);

		$this->assertTrue($this->bouncer->allowed('get', 'index'));
		$this->assertFalse($this->bouncer->allowed('post', 'something'));
	}

	public function testAuthorizeWithCallback()
	{
		$closure = function() {
			return false;
		};

		$this->bouncer->addRequiredAccess('post', 'index', $closure);

		$this->mockAuthority->shouldReceive('can')->with($closure, 'User')->andReturn(false);

		$this->assertTrue($this->bouncer->denied('post', 'index'));
		$this->assertFalse($this->bouncer->allowed('get', 'nothing'));
	}

	public function testGuestAccess()
	{
		$this->bouncer->addRequiredAccess('post', 'register', 'any');

		$this->assertTrue($this->bouncer->allowed('post', 'register'));
	}
}
