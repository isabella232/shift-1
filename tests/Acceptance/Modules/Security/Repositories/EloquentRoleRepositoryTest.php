<?php

namespace Tests\Acceptance\Modules\Security\Repositories;

use App;
use Tectonic\Shift\Modules\Security\Repositories\EloquentRoleRepository;
use Tests\AcceptanceTestCase;

class EloquentRoleRepositoryTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->roleRepository = App::make(EloquentRoleRepository::class);
    }

    public function testGetDefault()
    {
        $role = $this->roleRepository->getNew(['name' => 'Role']);

        $this->roleRepository->setDefault($role);

        $defaultRole = $this->roleRepository->getDefault();

        $this->assertEquals($role->id, $defaultRole->id);
    }

    public function testRetrievalViaPermission()
    {
        $role = $this->roleRepository->getNew(['name' => 'Role via permissions']);
        $this->roleRepository->save($role);
    }
}
