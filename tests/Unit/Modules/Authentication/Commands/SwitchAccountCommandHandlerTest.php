<?php namespace Tests\Unit\Modules\Authentication\Commands; 

use Mockery as m;
use Tests\UnitTestCase;
use Illuminate\Auth\AuthManager;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchAccountCommand;
use Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchAccountCommandHandler;

class SwitchAccountCommandHandlerTest extends UnitTestCase
{
    public function testCommandHandling()
    {
        // Arrange
        $user      = m::mock(User::class);
        $auth      = m::mock(AuthManager::class);
        $tokenRepo = m::mock(TokenRepositoryInterface::class);
        $token     = new TokenStub;

        $command         = new SwitchAccountCommand(new TokenStub);
        $commandHandler  = new SwitchAccountCommandHandler($tokenRepo, $auth);


        // Assert
        $tokenRepo->shouldReceive('getByToken')->once()->andReturn($token);
        $auth->shouldReceive('loginUsingId')->once()->andReturn($user);
        $tokenRepo->shouldReceive('delete')->once()->with($token);

        // Act
        $this->assertNotNull($commandHandler->handle($command));
    }
}

class TokenStub
{
    public $token = 'TOKEN';
    public $data  = '{"userId":1}';
}