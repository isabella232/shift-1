<?php
namespace Tests\Acceptance\Modules\Authentication;

use App;
use Mockery as m;
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
}