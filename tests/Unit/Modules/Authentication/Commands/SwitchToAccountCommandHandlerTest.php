<?php namespace Tests\Unit\Modules\Authentication\Commands;

use Mockery as m;
use Tectonic\Shift\Modules\Identity\Users\Models\User;
use Tests\UnitTestCase;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchToAccountCommand;
use Tectonic\Shift\Modules\Authentication\Commands\SwitchToAccountCommandHandler;

class SwitchToAccountCommandHandlerTest extends UnitTestCase
{
    public function testCommandHandling()
    {
        // Arrange
        $domain          = new DomainStub;
        $user            = m::mock(User::class);
        $domainRepo      = m::mock(DomainRepositoryInterface::class);
        $accountRepo     = m::mock(AccountRepositoryInterface::class);
        $eventDispatcher = m::mock(EventDispatcher::class);

        $command         = new SwitchToAccountCommand(1, $user);
        $commandHandler  = new SwitchToAccountCommandHandler($domainRepo, $accountRepo, $eventDispatcher);

        // Ready Assertions
        $user->shouldReceive('getAttribute')->twice();
        $accountRepo->shouldReceive('getByUser')->once()->andReturn($user);
        $accountRepo->shouldReceive('save')->once();
        $eventDispatcher->shouldReceive('dispatch')->once();
        $domainRepo->shouldReceive('getOneBy')->once()->andReturn($domain);

        // Act
        $this->assertNotNull($commandHandler->handle($command));
    }
}

class DomainStub
{
    public $domain = 'https://domain.dev';
}