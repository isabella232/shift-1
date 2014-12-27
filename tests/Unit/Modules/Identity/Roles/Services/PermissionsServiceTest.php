<?php
namespace Tests\Unit\Modules\Identity\Roles\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Identity\Roles\Contracts\PermissionRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Services\PermissionsService;
use Tests\UnitTestCase;

class PermissionsServiceTest extends UnitTestCase
{
    private $repository;
    private $service;

    public function init()
    {
        $this->repository = m::mock(PermissionRepositoryInterface::class);
        $this->service = new PermissionsService($this->repository);
    }

	public function testGetPermission()
    {
        $this->repository->shouldReceive('getByRole')->once()->andReturn('permissions');

        $this->assertEquals('permissions', $this->service->getPermission(new Role, 'resource', 'action'));
    }

    public function testUpdatePermission()
    {
        $this->repository->shouldReceive('getByRole')->once()->andReturn(null);
        $this->repository->shouldReceive('save')->once();

        $this->assertInstanceOf(Permission::class, $this->service->updatePermission(new Role, 'resource', 'action', 'allow'));
    }
}
