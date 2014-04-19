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
}
