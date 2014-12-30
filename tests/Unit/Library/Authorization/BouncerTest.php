<?php namespace Tests\Unit\Library\Authorization;

use Mockery as m;
use Tests\UnitTestCase;
use Tectonic\Shift\Library\Authorization\Bouncer;
use Tectonic\Shift\Library\Authorization\ConsumerManager;

class BouncerTest extends UnitTestCase
{
	private $bouncer;
	private $mockAuthority;

	public function setUp()
	{
		parent::setUp();

		$this->mockAuthority = m::mock('Authority\Authority');

		$this->bouncer = new Bouncer($this->mockAuthority, 'User');
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

	public function testAuthoriseWithDefaults()
	{
        $this->bouncer->setupDefaultAccess();

		$this->mockAuthority->shouldReceive('can')->once()->with('read', 'User')->andReturn(true);

		$this->assertTrue($this->bouncer->allowed('get', 'index'));
		$this->assertFalse($this->bouncer->allowed('post', 'something'));
	}

	public function testAuthoriseWithCallback()
	{
        $closure = function() { return true; };

		$this->bouncer->addRequiredAccess('post', 'index', $closure);

		$this->assertTrue($this->bouncer->allowed('post', 'index'));
	}

	public function testAuthoriseWithArray()
	{
		$this->bouncer->setupDefaultAccess();
		$this->bouncer->addRequiredAccess('post', 'index', ['Entry' => ['create', 'read']]);

		$this->mockAuthority->shouldReceive('can')->with('create', 'User')->once()->andReturn(false);
		$this->mockAuthority->shouldReceive('can')->with('create', 'Entry')->once()->andReturn(false);
		$this->mockAuthority->shouldReceive('can')->with('read', 'Entry')->once()->andReturn(true);

		$this->assertTrue($this->bouncer->allowed('post', 'index'));
		$this->assertFalse($this->bouncer->allowed('post', 'creator'));
	}

	public function testAuthoriseWithArrayWithAllFailures()
	{
		$this->bouncer->addRequiredAccess('post', 'index', ['Entry' => ['create', 'read']]);

		$this->mockAuthority->shouldReceive('can')->with('create', 'Entry')->twice()->andReturn(false);
		$this->mockAuthority->shouldReceive('can')->with('read', 'Entry')->twice()->andReturn(false);

		$this->assertFalse($this->bouncer->allowed('post', 'index'));
		$this->assertTrue($this->bouncer->denied('post', 'index'));
	}

	public function testGuestAccess()
	{
        $this->bouncer->addRequiredAccess('post', 'register', 'guest');

		$this->assertTrue($this->bouncer->allowed('post', 'register'));
	}
}
