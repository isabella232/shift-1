<?php

use Illuminate\Support\Facades\Route;

class UsersTest extends Tests\TestCase
{

    protected $userModel;

    public function setUp()
    {
        parent::setUp();

        $this->userModel = new \Tectonic\Shift\Modules\Accounts\Models\User;
    }
    public function testStoreNewUser()
    {
        // Arrange
        $data = [
            'name' => 'Test User',
            'url'  => 'http://www.google.com'
        ];

        // Act
        $this->call('POST', 'users', $data);
        $newUser = $this->userModel->where('name', '=', $data['name'])->first();

        // Assert
        $this->assertResponseOk();
        $this->assertSame($data['name'], $newUser->name);
    }

    public function testGetAllUsers()
    {
        // Act
        $this->call('GET', 'users');

        // Assert
        $this->assertResponseOk();
    }

}
