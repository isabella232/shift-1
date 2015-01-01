<?php
namespace Tests\Acceptance\Modules\Identity\Roles\Repositories;

use App;
use Tectonic\Shift\Modules\Identity\Roles\Repositories\EloquentRoleRepository;
use Tests\AcceptanceTestCase;

class EloquentRoleRepositoryTest extends AcceptanceTestCase
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

    public function testRetrievalViaPermission()
    {
        $role = $this->roleRepository->getNew();
        $this->roleRepository->save($role);
    }
}
