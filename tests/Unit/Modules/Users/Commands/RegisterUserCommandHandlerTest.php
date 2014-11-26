<?php
namespace Tests\Unit\Modules\Users\Commands;

use Mockery as m;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Users\Commands\RegisterUserCommand;
use Tectonic\Shift\Modules\Users\Commands\RegisterUserCommandHandler;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tests\UnitTestCase;

class RegisterUserCommandHandlerTest extends UnitTestCase
{
    public function testCommandHandling()
    {
        $repository = m::spy(UserRepositoryInterface::class);
        $currentAccount = m::mock(CurrentAccountService::class);
        $account = m::mock(Account::class);
        $eventDispatcher = m::spy(EventDispatcher::class);

        $commandHandler = new RegisterUserCommandHandler($repository, $currentAccount, $eventDispatcher);
        $command = new RegisterUserCommand('Kirk', 'Bushell', 'blah@blah.com', 'lijsdflkjsdf', 'lkajsdflkjsdf');

        $currentAccount->shouldReceive('get')->once()->andReturn($account);
        $account->shouldReceive('addUser')->once();

        $this->assertNotNull($commandHandler->handle($command));

        $repository->shouldHaveReceived('save')->once();
        $eventDispatcher->shouldHaveReceived('dispatch')->once();
    }
}
