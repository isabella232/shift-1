<?php
namespace Tectonic\Shift\Modules\Identity\Users\Commands;

use Tectonic\Application\Commanding\CommandHandlerInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class UpdateUserProfileCommandHandler implements CommandHandlerInterface
{
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Handle the command.
     *
     * @param $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        // Updated profile details.
        $updatedProfileData = [
            'firstName' => $command->firstName,
            'lastName'  => $command->lastName,
            'email'     => $command->email
        ];

        // If a new password has been provided, update that too.
        if (strlen($command->password) > 0) {
            $updatedProfileData['password'] = $command->password;
        }

        // Update profile details and return.
        return $this->userRepo->update($command->user, $updatedProfileData);
    }
}