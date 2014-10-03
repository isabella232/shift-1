<?php

namespace Tests\Acceptance\Modules\Security\Repositories;

use App;
use Tectonic\Shift\Modules\Security\Entities\Role;
use Tectonic\Shift\Modules\Security\Repositories\DoctrineRoleRepository;
use Tests\AcceptanceTestCase;

class DoctrineRoleRepositoryTest extends AcceptanceTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->roleRepository = App::make(DoctrineRoleRepository::class);
    }

    public function testGetDefault()
    {
        $role = new Role($this->account, 'role');
        $role->setDefault(true);

        $this->roleRepository->save($role);

        $defaultRole = $this->roleRepository->getByDefault();

        $this->assertEquals($role, $defaultRole);
    }
}
