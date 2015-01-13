<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Eventing\EventDispatcher;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class UpdateUserCommandHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @param EventDispatcher $dispatcher
     * @param UserRepositoryInterface $userRepository
     */
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
        $user = $this->userRepository->requireBySlug($command->slug);
        $user->edit($command->firstName, $command->lastName, $command->email, $command->password);

        $this->userRepository->save($user);

        $this->dispatcher->dispatch($user->releaseEvents());
    }
}
