<?php
namespace Tests\Acceptance\Modules\Users\Services;

use App;
use Mockery as m;
use Tectonic\Shift\Modules\Users\Contracts\RegistrationObserverInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Services\RegistrationService;
use Tests\AcceptanceTestCase;

class RegistrationServiceTest extends AcceptanceTestCase
{
    private $service;

    public function init()
    {
        $this->service = App::make(RegistrationService::class);
        $this->userRepository = App::make(UserRepositoryInterface::class);
    }

    public function testSuccessfulRegistration()
    {
        $observer = m::spy(RegistrationObserverInterface::class);

        $this->service->registerUser([
            'firstName' => 'Kirk',
            'lastName' => 'Bushell',
            'email' => 'blah@blah.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ], $observer);

        $user = $this->userRepository->getAll()->first();

        // Assert
        $observer->shouldHaveReceived('onSuccess')->once();
        $this->assertNotNull($user);
        $this->assertNotNull($user->confirmationToken);
    }
}
 