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
        $previousDefaultRole = m::mock('defaultRole');
        $previousDefaultRole->id = 1;
        $previousDefaultRole->shouldReceive('save')->once();
        $previousDefaultRole->shouldReceive('getDirty')->once()->andReturn(true);

        $newRole = m::mock('Tectonic\Shift\Modules\Security\Models\Role')->makePartial();
        $newRole->shouldReceive('getDirty')->once()->andReturn(true);
        $newRole->shouldReceive('setAttribute')->with('default', true)->once();
        $newRole->shouldReceive('save')->once();
        $newRole->id = 2;

        $mockModel = m::mock('Tectonic\Shift\Modules\Security\Models\Role');
        $mockModel->shouldReceive('whereDefault')->once()->with(true)->andReturn($mockModel);
        $mockModel->shouldReceive('first')->once()->andReturn($previousDefaultRole);

        $repository = new RoleRepository($mockModel);
        $repository->setDefault($newRole);
    }
}
