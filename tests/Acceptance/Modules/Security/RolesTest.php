<?php

namespace Tests\Api\Security;

use App;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Security\Contracts\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;

class RolesTest extends AcceptanceTestCase
{
    protected $roleRepository;

    public function setUp()
    {
        parent::setUp();

        $this->roleRepository = App::make(RoleRepositoryInterface::class);
        $this->accountRepository = App::make(AccountRepositoryInterface::class);
    }

    public function testStoreNewRole()
    {
        // Arrange
        $data = [
            'name'       => 'Test Role',
            'default'    => false
        ];

        // Act
        $this->call('POST', 'roles', $data);

        $newRole = $this->roleRepository->getOneBy('name', $data['name']);

        // Assert
        $this->assertResponseOk();
        $this->assertSame($data['name'], $newRole->name);
    }

    public function testSetDefaultRole()
    {
	    $this->createNewRole(['default' => true]);

        $newRoleData = [
            'default' => true,
            'name' => 'New default role'
        ];

        // Act
        $this->call('POST', 'roles', $newRoleData);

        // Assert
        $newDefaultRole = $this->roleRepository->getOneBy('default', true);
        $otherRole = $this->roleRepository->getOneBy('default', false);

        $this->assertResponseOk();
        $this->assertEquals('New default role', $newDefaultRole->name);
        $this->assertEquals('Existing role', $otherRole->name);
    }

    public function testGetAllRoles()
    {
	    $this->createNewRole();

        // Act
        $this->response = $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
        $this->assertCount(1, $this->parseResponse());
    }

    public function testDeleteRole()
    {
        $role = $this->createNewRole();

        $this->call('DELETE', 'roles', [$role->id]);

        $deletedRole = $this->roleRepository->getById($role->id);

        // Assert
        $this->assertResponseOk();
        $this->assertNull($deletedRole);
    }

    public function testUpdateRole()
    {
        $existingRole = $this->createNewRole();

        $this->response = $this->call('PUT', 'roles/'.$existingRole->id, ['name' => 'Updated role name']);

        $updatedRole = $this->roleRepository->getById($existingRole->id);

        $this->assertEquals('Updated role name', $updatedRole->name);
    }

    public function testGetSpecificRole()
    {
        $existingRole = $this->createNewRole();

        $this->response = $this->call('GET', 'roles/'.$existingRole->id);
        $parsedRole = $this->parseResponse();

        $this->assertEquals($existingRole->id, $parsedRole->id);
        $this->assertEquals($existingRole->name, $parsedRole->name);
        $this->assertEquals((int) $existingRole->default, $parsedRole->default);
    }

    /**
     * Used to create new role objects, including using some default data if no requirements are needed.
     *
     * @param array $data
     * @return mixed
     */
    private function createNewRole($data = [])
    {
        $defaultData = [
            'default' => false,
            'name' => 'Existing role'
        ];

        $roleData = array_merge($defaultData, $data);

	    $role = $this->roleRepository->getNew($roleData);

        $this->roleRepository->save($role);

        return $role;
    }
}
