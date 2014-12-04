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
        $command        = new UpdateUserProfileCommand(1, 'Test', 'User', 'test@email.dev', 'password', 'password');
        $userRepository = m::mock(UserRepositoryInterface::class);
        $commandHandler = new UpdateUserProfileCommandHandler($userRepository);

        // Ready Assertions
        $userRepository->shouldReceive('getOneBy')->once()->andReturn($user);
        $user->shouldReceive('update')->once();

        // Act
        $this->assertNotNull($commandHandler->handle($command));
    }
} 