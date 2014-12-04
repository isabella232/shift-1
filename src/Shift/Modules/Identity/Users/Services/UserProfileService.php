<?php
namespace Tectonic\Shift\Modules\Identity\Users\Services;

use Tectonic\Application\Validation\ValidationException;
use Tectonic\Application\Validation\ValidationCommandBus;
use Tectonic\Shift\Modules\Identity\Users\Commands\UpdateUserProfileCommand;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserProfileObserverInterface;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface;

class UserProfileService
{
    /**
     * @var \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var \Tectonic\Application\Validation\ValidationCommandBus
     */
    protected $commandBus;

    /**
     * @param \Tectonic\Application\Validation\ValidationCommandBus                    $commandBus
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserRepositoryInterface $userRepository
     */
    public function __construct(ValidationCommandBus $commandBus, UserRepositoryInterface $userRepository)
    {
        $this->commandBus     = $commandBus;
        $this->userRepository = $userRepository;
    }

    /**
     * Collect and return currently logged in users profile
     *
     * @param int $userId
     *
     * @return mixed
     */
    public function getUserProfile($userId)
    {
        $user = $this->userRepository->getOneBy('id', $userId);

        return $user;
    }

    /**
     * Update user profile information
     *
     * @param int                                                                           $userId
     * @param array                                                                         $input
     * @param \Tectonic\Shift\Modules\Identity\Users\Contracts\UserProfileObserverInterface $responder
     *
     * @return mixed
     */
    public function updateProfile($userId, $input, UserProfileObserverInterface $responder)
    {
        try {
            $command = new UpdateUserProfileCommand(
                $userId, $input['firstName'], $input['lastName'], $input['email'], $input['password'], $input['passwordConfirmation']
            );

            $updatedUserProfile = $this->commandBus->execute($command);

            return $responder->onSuccess($updatedUserProfile);
        } catch(ValidationException $e) {
            return $responder->onValidationFailure($e);
        }
    }
} 