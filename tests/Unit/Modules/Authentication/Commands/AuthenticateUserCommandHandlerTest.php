<?php
namespace Tests\Unit\Modules\Authentication\Commands;

use Mockery as m;
use Tectonic\Application\Eventing\EventDispatcher;
use Tests\UnitTestCase;
use Illuminate\Auth\AuthManager;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tectonic\Shift\Modules\Authentication\Commands\AuthenticateUserCommand;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Commands\AuthenticateUserCommandHandler;

class AuthenticateUserCommandHandlerTest extends UnitTestCase
{
    public function testCommandHandling()
    {
        // Arrange
        $user            = m::mock(User::class);
        $authManager     = m::mock(AuthManager::class);
        $userRepository  = m::mock(UserRepositoryInterface::class);
        $eventDispatcher = m::mock(EventDispatcher::class);
        $command         = new AuthenticateUserCommand('test@email.dev', 'password', false);
        $commandHandler  = new AuthenticateUserCommandHandler($userRepository, $authManager, $eventDispatcher);

        // Ready Assertions
        $authManager->shouldReceive('validate')->once()->andReturn(true);
        $authManager->shouldReceive('login')->once();
        $authManager->shouldReceive('getUser')->once()->andReturn($user);
        $userRepository->shouldReceive('getByEmailAndAccount')->once()->andReturn($user);
        $eventDispatcher->shouldReceive('dispatch')->once();

        // Act
        $this->assertNotNull($commandHandler->handle($command));
    }
}