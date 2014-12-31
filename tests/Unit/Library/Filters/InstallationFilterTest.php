<?php
namespace Tests\Unit\Library\Filters;

use Mockery as m;
use Tectonic\Shift\Library\Filters\InstallationFilter;
use Tectonic\Shift\Modules\Accounts\Services\AccountManagementService;
use Tests\UnitTestCase;

class InstallationFilterTest extends UnitTestCase
{
    private $mockAccountManagementService;
    private $filter;

	public function init()
    {
        $this->mockAccountManagementService = m::mock(AccountManagementService::class);
        $this->filter = new InstallationFilter($this->mockAccountManagementService);
    }

    /**
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testInstallationAlreadyCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(1);

        $this->filter->filter();
    }
    
    public function testInstallationNeedsToBeCompleted()
    {
        $this->mockAccountManagementService->shouldReceive('totalNumberOfAccounts')->andReturn(0);

        $this->filter->filter();
    }
}
