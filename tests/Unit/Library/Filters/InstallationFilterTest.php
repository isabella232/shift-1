<?php
namespace Tests\Unit\Library\Filters;

use Illuminate\Support\Facades\App;
use Mockery as m;
use Tectonic\Shift\Library\Filters\InstallationFilter;
use Tectonic\Shift\Modules\Accounts\Services\AccountsService;
use Tests\UnitTestCase;

class InstallationFilterTest extends UnitTestCase
{
    private $mockAccountManagementService;
    private $filter;

	public function init()
    {
        $this->mockAccountManagementService = m::mock(AccountsService::class);

        $this->filter = new InstallationFilter($this->mockAccountManagementService);
    }

    public function testInstallationAlreadyCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(1);
        App::shouldReceive('abort')->with(404)->once();

        $this->filter->filter();
    }

    public function testInstallationNeedsToBeCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

        $this->filter->filter();
    }
}
