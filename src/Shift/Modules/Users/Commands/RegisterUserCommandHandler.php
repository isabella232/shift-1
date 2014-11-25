<?php
namespace Tectonic\Shift\Modules\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Users\Contracts\UserRepositoryInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $users;

    /**
     * @param UserRepositoryInterface $users
     */
    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the command.
     *
     * @param $command
     */
    public function handle($command)
    {
        $user = User::register($command->firstName, $command->lastName, $command->email, $command->password);

        $this->users->save($user);
    }
}
 