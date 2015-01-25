<?php
namespace Tests\Unit\Library\Middleware;

use Illuminate\Support\Facades\App;
use Mockery as m;
use Tectonic\Shift\Library\Middleware\InstallationMiddleware;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tests\UnitTestCase;

class InstallationMiddlewareTest extends UnitTestCase
{
    private $mockAccountManagementService;
    private $middleware;

	public function init()
    {
        $this->mockAccountManagementService = m::mock(AccountsService::class);

        $this->middleware = new InstallationMiddleware($this->mockAccountManagementService);
    }

    public function testInstallationAlreadyCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(1);
        App::shouldReceive('abort')->with(404)->once();

        $this->middleware->handle('request', function() {});
    }

    public function testInstallationNeedsToBeCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

        $this->middleware->handle('request', function() {});
    }
}
