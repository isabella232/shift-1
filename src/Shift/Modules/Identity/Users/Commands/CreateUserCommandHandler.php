<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    function __construct(EventDispatcher $dispatcher, UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $user = User::add($command->firstName, $command->lastName, $command->email, $command->password);

        $this->userRepository->save($user);

        $this->dispatcher->dispatch($user->releaseEvents());
    }
}
