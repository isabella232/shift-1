<?php

use Illuminate\Support\Facades\Route;

class RolesTest extends Tests\TestCase
{
    protected $roleModel;

    public function setUp()
    {
        parent::setUp();

        $this->roleModel = new \Tectonic\Shift\Modules\Security\Models\Role;
    }

    public function testStoreNewRole()
    {
        // Arrange
        $data = [
            'account_id' => 1,
            'access'     => 1,
            'name'       => 'Test Role',
            'default'    => false
        ];

        // Act
        $this->call('POST', 'roles', $data);
        $newRole = $this->roleModel->whereName($data['name'])->first();

        // Assert
        $this->assertResponseOk();
        $this->assertSame($data['name'], $newRole->name);
    }

    public function testSetDefaultRole()
    {
        $existingRoleData = [
            'account_id' => null,
            'access' => 1,
            'default' => true,
            'name' => 'Existing role'
        ];

        $this->roleModel->create($existingRoleData);

        $newRoleData = [
            'account_id' => null,
            'access' => 1,
            'default' => true,
            'name' => 'New default role'
        ];

        // Act
        $this->call('POST', 'roles', $newRoleData);

        // Assert
        $newDefaultRole = $this->roleModel->whereDefault(true)->get();
        $otherRoles = $this->roleModel->whereDefault(false)->get();

        $this->assertResponseOk();
        $this->assertCount(1, $newDefaultRole);
        $this->assertCount(1, $otherRoles);
        $this->assertSame($newRoleData['name'], $newDefaultRole[0]->name);
        $this->assertSame($existingRoleData['name'], $otherRoles[0]->name);
    }

    public function testGetAllRoles()
    {
        // Act
        $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
    }

    public function testDeleteRole()
    {
        $existingRoleData = [
            'account_id' => null,
            'access' => 1,
            'default' => false,
            'name' => 'Existing role'
        ];

        $role = $this->roleModel->create($existingRoleData);

        // Act
        $this->call('DELETE', 'roles', [$role->id]);

        $deletedRole = $this->roleModel->withTrashed()->find($role->id);

        // Assert
        $this->assertResponseOk();
        $this->assertThat(
            $deletedRole->deleted_at,
            $this->logicalNot($this->equalTo(null))
        );
    }
}
