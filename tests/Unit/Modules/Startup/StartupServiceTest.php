<?php

namespace Tests\Unit\Modules\Startup;

use Tectonic\Shift\Modules\Startup\StartupService;
use Tests\TestCase;

class StartupServiceTest extends TestCase
{
	private $startupService;

	public function setUp()
	{
		parent::setUp();

		$this->startupService = new StartupService();
	}

	public function testConfigurationValueReturned()
	{
		$this->assertEquals([], $this->startupService->configuration());
	}
}
