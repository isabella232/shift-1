<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Accounts\Models\Account;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    use EventDispatcher;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CurrentAccountService
     */
    private $currentAccountService;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository, CurrentAccountService $currentAccountService)
    {
        $this->userRepository = $userRepository;
        $this->currentAccountService = $currentAccountService;
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

        $this->dispatch($user->releaseEvents());

        return $user;
    }
}
