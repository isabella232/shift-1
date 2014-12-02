<?php
namespace Tests\Acceptance\Modules\Authentication;

use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;
use Tests\AcceptanceTestCase;
use Illuminate\Support\Facades\App;
use Tectonic\Shift\Modules\Authentication\Services\AuthenticationService;

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
            'email' => 'email@address.dev',
            'password' => '',               // Missing password, should cause validation failure.
            'remember' => false
        ], $observer);

        // Assert
        $observer->shouldHaveReceived('onValidationFailure')->once();
    }

}