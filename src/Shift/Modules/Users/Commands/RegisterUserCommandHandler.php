<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Users\Models\User;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CurrentAccountService
     */
    private $currentAccountService;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CurrentAccountService $currentAccountService,
        EventDispatcher $eventDispatcher
    )
    {
        $this->userRepository = $userRepository;
        $this->currentAccountService = $currentAccountService;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $user = User::register($command->firstName, $command->lastName, $command->email, $command->password);

        $this->userRepository->save($user);

        $account = $this->currentAccountService->get();
        $account->addUser($user);

        $this->eventDispatcher->dispatch($user->releaseEvents());

        return $user;
    }
}
