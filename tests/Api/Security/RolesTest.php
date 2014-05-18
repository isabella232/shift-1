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
            'name'       => 'Test Role'
        ];

        // Act
        $this->call('POST', 'roles', $data);
        $newRole = $this->roleModel->where('name', '=', $data['name'])->first();

        // Assert
        $this->assertResponseOk();
        $this->assertSame($data['name'], $newRole->name);
    }

    public function testGetAllRoles()
    {
        // Act
        $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
    }
}
