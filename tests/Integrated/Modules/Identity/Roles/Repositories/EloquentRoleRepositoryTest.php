<?php
namespace Tests\Integrated\Modules\Identity\Roles\Repositories;

use App;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentRoleRepository;
use Tests\IntegratedTestCase;

class EloquentRoleRepositoryTest extends IntegratedTestCase
{
    public function init()
    {
        $this->roleRepository = App::make(EloquentRoleRepository::class);
    }

    public function testGetDefault()
    {
        $role = $this->roleRepository->getNew();

        $this->roleRepository->setDefault($role);

        $defaultRole = $this->roleRepository->getDefault();

        $this->assertEquals($role->id, $defaultRole->id);
    }

    public function testSetDefault()
    {
        $role = $this->roleRepository->getNew();
        $this->roleRepository->setDefault($role);

        $role2 = $this->roleRepository->getNew();
        $this->roleRepository->setDefault($role2);

        // This tests a special use-case
        $this->roleRepository->setDefault($role2);

        $defaultRole = $this->roleRepository->getDefault();

        $this->assertEquals($role2->id, $defaultRole->id);
    }
}
