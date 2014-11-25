<?php
namespace Tectonic\Shift\Modules\Users\Contracts;

use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Users\Models\User;

interface RegistrationObserverInterface
{
    /**
     * Called when a validation exception is thrown by the command handler.
     *
     * @param ValidationException $e
     * @return mixed
     */
    public function onValidationError(ValidationException $e);

    /**
     * When registration has succeeded, then the $user object that was created is passed
     * back and can be handled by this observer method.
     *
     * @param User $user
     * @return mixed
     */
    public function onSuccess(User $user);
}
