<?php
namespace Tectonic\Shift\Modules\Identity\Users\Contracts;

use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

interface UserProfileObserverInterface
{
    /**
     * Called once the user profile has been successfully updated.
     *
     * @param User $user
     * @return mixed
     */
    public function onSuccess(User $user);

    /**
     * Called when a validation exception is thrown by the command handler.
     *
     * @param ValidationException $e
     * @return mixed
     */
    public function onValidationFailure(ValidationException $e);
} 