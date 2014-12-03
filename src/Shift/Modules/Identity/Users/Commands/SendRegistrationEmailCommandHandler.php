<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class SendRegistrationEmailCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the command.
     *
     * @param SendRegistrationEmailCommand $command
     */
    public function handle($command)
    {
        $user = $command->user;
        $user->generateConfirmationToken();

        $this->userRepository->save($user);

        // TODO: Implement based on notifications module
//        Notifier::make($user->email, 'users.register', [
//            'name' => $user->getName(),
//            'confirmation_url' => URL::base() . '/users/confirm/' . $user->confirmation_token
//        ]);
    }
}
 