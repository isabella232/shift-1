<?php

namespace Tests\Api\Security;

use App;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface;

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

        $newRole = $this->roleRepository->getBy('name', $data['name']);

        // Assert
        $this->assertResponseOk();
        $this->assertSame($data['name'], $newRole[0]->getName());
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
        $newDefaultRole = $this->roleRepository->getBy('default', true);
        $otherRoles = $this->roleRepository->getBy('default', false);

        $this->assertResponseOk();
        $this->assertCount(1, $newDefaultRole);
        $this->assertCount(1, $otherRoles);
    }

    public function testGetAllRoles()
    {
	    $role = $this->createNewRole();

        // Act
        $this->response = $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
        $this->assertCount(1, $this->parseResponse());
    }

    public function testDeleteRole()
    {
        $role = $this->createNewRole();

        $this->call('DELETE', 'roles', [$role->getId()]);

        $deletedRole = $this->roleRepository->getById($role->getId());

        // Assert
        $this->assertResponseOk();
        $this->assertNull($deletedRole);
    }

    public function testUpdateRole()
    {
        $existingRole = $this->createNewRole();

        $this->response = $this->call('PUT', 'roles/'.$existingRole->getId(), ['name' => 'Updated role name']);

        $updatedRole = $this->roleRepository->getById($existingRole->getId());

        $this->assertEquals('Updated role name', $updatedRole->getName());
    }

    public function testGetSpecificRole()
    {
        $existingRole = $this->createNewRole();

        $this->response = $this->call('GET', 'roles/'.$existingRole->getId());
        $parsedRole = $this->parseResponse();

        $this->assertEquals($existingRole->getId(), $parsedRole->id);
        $this->assertEquals($existingRole->getName(), $parsedRole->name);
        $this->assertEquals((int) $existingRole->getDefault(), $parsedRole->default);
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
	    $role->setAccount($this->account);

	    $role = $this->roleRepository->save($role);

        return $role;
    }
}
