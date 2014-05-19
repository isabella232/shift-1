<?php

use Mockery as m;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepository;

class RoleRepositoryTest extends Tests\TestCase
{
    public function testSearchingForDefaultRolesShouldExecuteAppropriateMethods()
    {
        $mockModel = m::mock('Tectonic\Shift\Modules\Security\Models\Role');
        $mockModel->shouldReceive('whereDefault')->once()->with(true)->andReturn($mockModel);
        $mockModel->shouldReceive('first')->once()->andReturn('defaultRole');

        $repository = new RoleRepository($mockModel);

        $this->assertEquals('defaultRole', $repository->getByDefault());
    }

    public function testSettingRoleDefaultShouldUpdatePreviousDefaultRoleAsWell()
    {
        $previousDefaultRole = m::mock('defaultRole')->makePartial();
        $previousDefaultRole->id = 1;
        $previousDefaultRole->shouldReceive('getDirty')->once()->andReturn([]);

        $newRole = m::mock('Tectonic\Shift\Modules\Security\Models\Role')->makePartial();
        $newRole->shouldReceive('save')->once();
        $newRole->id = 2;
        $newRole->default = true;

        $mockModel = m::mock('Tectonic\Shift\Modules\Security\Models\Role');
        $mockModel->shouldReceive('whereDefault')->once()->with(true)->andReturn($mockModel);
        $mockModel->shouldReceive('first')->once()->andReturn($previousDefaultRole);

        $repository = new RoleRepository($mockModel);
        $repository->setDefault($newRole);
    }
}