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

        $this->assertResponseOk();
        $this->assertCount(1, $newDefaultRole);
        $this->assertSame($newRoleData['name'], $newDefaultRole[0]->name);
    }

    public function testGetAllRoles()
    {
        // Act
        $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
    }
}
