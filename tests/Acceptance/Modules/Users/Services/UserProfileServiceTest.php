<?php
namespace Tests\Acceptance\Modules\Users\Services;

use Mockery as m;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tests\AcceptanceTestCase;
use Illuminate\Support\Facades\App;
use Tectonic\Shift\Modules\Identity\Users\Services\UserProfileService;
use Tectonic\Shift\Modules\Identity\Users\Observers\UserProfileResponder;

class UserProfileServiceTest extends AcceptanceTestCase
{
    protected $service;

    public function init()
    {
        $this->service = App::make(UserProfileService::class);
    }

    public function testOnValidationFailure()
    {
        // Arrange
        $user = $this->createTempUser();
        $observer = m::spy(UserProfileResponder::class);
        $testData = [
            'firstName' => 'Test',
            'lastName'  => 'User',
            'email'     => 'email.address.dev', // Invalid email address should cause validation exception
            'password'  => '',
            'passwordConfirmation'  => '',
        ];

        // Act
        $this->be($user); // Set logged in user
        $this->service->updateProfile($testData, $observer);

        // Assert.
        $observer->shouldHaveReceived('onValidationFailure')->once();

        $resultUser = App::make(UserRepositoryInterface::class)->getOneBy('id', $user->id);
        $this->assertNotSame($resultUser->email, $testData['email']);
    }

    public function testOnSuccess()
    {
        // Arrange
        $user = $this->createTempUser();
        $observer = m::spy(UserProfileResponder::class);
        $testData = [
            'firstName' => 'Test',
            'lastName'  => 'User',
            'email'     => 'new-email@address.dev',
            'password'  => '',
            'passwordConfirmation'  => '',
        ];

        // Act
        $this->be($user); // Set logged in user
        $this->service->updateProfile($testData, $observer);

        // Assert.
        $observer->shouldHaveReceived('onSuccess')->once();

        $resultUser = App::make(UserRepositoryInterface::class)->getOneBy('id', $user->id);
        $this->assertSame($resultUser->email, $testData['email']);
    }

    private function createTempUser()
    {
        $userRepository = App::make(UserRepositoryInterface::class);

        $user = $userRepository->getNew();

        $user->first_name = "Test";
        $user->last_name = "User";
        $user->email = "email@address.dev";
        $user->password = 'password';

        $userRepository->save($user);

        return $userRepository->getByEmail($user->email);
    }
}