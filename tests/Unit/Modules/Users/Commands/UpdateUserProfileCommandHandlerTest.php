<?php
namespace Tests\Unit\Modules\Users\Commands;

use Mockery as m;
use Tests\UnitTestCase;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tectonic\Shift\Modules\Identity\Users\Commands\UpdateUserProfileCommand;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Commands\UpdateUserProfileCommandHandler;

class UpdateUserProfileCommandHandlerTest extends UnitTestCase
{
    public function testCommandHandling()
    {
        // Arrange
        $user           = m::mock(User::class);
        $command        = new UpdateUserProfileCommand($user, 'Test', 'User', 'test@email.dev', 'password', 'password');
        $userRepository = m::mock(UserRepositoryInterface::class);
        $commandHandler = new UpdateUserProfileCommandHandler($userRepository);

        // Ready Assertions
        $userRepository->shouldReceive('update')->once()->andReturn($user);

        // Act
        $this->assertNotNull($commandHandler->handle($command));
    }
} 