<?php
namespace Tests\Acceptance\Modules\Identity\Roles\Repositories;

use Tectonic\Shift\Modules\Identity\Roles\Models\Permission;
use Tectonic\Shift\Modules\Identity\Roles\Models\Role;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentPermissionRepository;
use Tectonic\Shift\Modules\Identity\Roles\ValueObjects\Mode;
use Tests\AcceptanceTestCase;

class EloquentPermissionRepositoryTest extends AcceptanceTestCase
{
	public function init()
    {
        $this->repository = $this->app->make(EloquentPermissionRepository::class);
        $this->setupDefaultRoles();
    }

    public function testRoleSearchByRole()
    {
        $this->assertCount(1, $this->repository->getByRole(3));
    }

    public function testRoleSearchByRoleAndResource()
    {
        $this->assertCount(2, $this->repository->getByRole(1, 'permission'));
    }

    public function testRoleSearchByRoleResourceAndAction()
    {
        $this->assertCount(1, $this->repository->getByRole(2, 'perm', 'testa'));
    }

    public function testRoleSearchByRoleAndAction()
    {
        $this->assertCount(1, $this->repository->getByRole(1, null, 'test2'));
    }

    private function setupDefaultRoles()
    {
        $permission = new Permission;
        $permission->roleId = 1;
        $permission->resource = 'permission';
        $permission->action = 'test';
        $permission->mode = new Mode('inherit');

        $this->repository->save($permission);

        $permission = new Permission;
        $permission->roleId = 1;
        $permission->resource = 'permission';
        $permission->action = 'test2';
        $permission->mode = new Mode('allow');

        $this->repository->save($permission);

        $permission = new Permission;
        $permission->roleId = 2;
        $permission->resource = 'perm';
        $permission->action = 'testa';
        $permission->mode = new Mode('deny');

        $this->repository->save($permission);

        $permission = new Permission;
        $permission->roleId = 2;
        $permission->resource = 'something';
        $permission->action = 'tester';
        $permission->mode = new Mode('inherit');

        $this->repository->save($permission);

        $permission = new Permission;
        $permission->roleId = 3;
        $permission->resource = 'permission';
        $permission->action = 'nothing';
        $permission->mode = new Mode('allow');

        $this->repository->save($permission);
    }
}
