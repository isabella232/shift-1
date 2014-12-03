<?php
namespace Tests\Acceptance\Modules\Authentication;

use App;
use Hash;
use Mockery as m;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tests\AcceptanceTestCase;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;
use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;

class AuthenticationServiceTest extends AcceptanceTestCase
{
    protected $service;

    public function init()
    {
        $this->service = App::make(AuthenticationService::class);
    }

    public function testValidationFailureOnLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Act
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => '',                  // Missing password, should cause validation failure.
            'remember' => false
        ], $observer);

        // Assert.
        $observer->shouldHaveReceived('onValidationFailure')->once();
    }

    public function testAuthenticationFailureOnLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Act (Incorrect email & password combination should cause authentication failure)
        $this->service->login([
            'email'    => 'email@address.dev',
            'password' => 'password',
            'remember' => false
        ], $observer);

        // Assert.
        $observer->shouldHaveReceived('onAuthenticationFailure')->once();
    }

    public function testUserAccountFailureLogin()
    {
        // Arrange
        $observer = m::spy(AuthenticationResponderInterface::class);

        // Create a new user, that isn't associated with the current account.
        $userRepository = App::make(UserRepositoryInterface::class);

        $user = $userRepository->getNew();

        $user->first_name = "Test";
        $user->last_name = "User";
        $user->email = "email@address.dev";
        $user->password = Hash::make('password');

        $userRepository->save($user);

        $tempUser = $userRepository->getByEmail($user->email);

        // Act (Incorrect email & password combination should cause authentication failure)
        /*$this->service->login([
            'email'    => 'email@address.dev',
            'password' => 'password',
            'remember' => false
        ], $observer);*/

        // Assert.
        $this->assertSame(1, (int)$tempUser->id);

        //$observer->shouldHaveReceived('onAuthenticationFailure')->once();
    }
}