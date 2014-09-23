<?php

namespace Tests\Unit\Modules\Startup;

use Mockery as m;
use Tectonic\Shift\Modules\Configuration\Repositories\SettingRepositoryInterface;
use Tectonic\Shift\Modules\Startup\StartupService;
use Tests\UnitTestCase;

class StartupServiceTest extends UnitTestCase
{
	private $startupService;

	public function setUp()
	{
		parent::setUp();

        $this->mockRepository = m::mock(SettingRepositoryInterface::class);
		$this->startupService = new StartupService($this->mockRepository);
	}

	public function testConfigurationValueReturned()
	{
        $this->mockRepository->shouldReceive('getAllAsKeyValue')->once()->andReturn('settings');

		$this->assertEquals(['settings' => 'settings'], $this->startupService->configuration());
	}
}
