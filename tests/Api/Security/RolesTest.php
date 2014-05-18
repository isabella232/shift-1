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

    public function test_store_new_role()
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

    public function test_get_all_roles()
    {
        // Act
        $this->call('GET', 'roles');

        // Assert
        $this->assertResponseOk();
    }
}
