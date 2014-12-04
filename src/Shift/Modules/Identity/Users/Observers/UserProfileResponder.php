<?php
namespace Tectonic\Shift\Modules\Identity\Users\Observers;

use Illuminate\Support\Facades\Redirect;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Controllers\UserController;
use Tectonic\Shift\Modules\Identity\Users\Contracts\UserProfileObserverInterface;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

class UserProfileResponder implements UserProfileObserverInterface
{
    /**
     * Called once the user profile has been successfully updated.
     *
     * @param User $user
     * @return mixed
     */
    public function onSuccess(User $user)
    {
        return Redirect::action(UserController::class.'@profile');
    }

    /**
     * Called when a validation exception is thrown by the command handler.
     *
     * @param ValidationException $e
     *
     * @return mixed
     */
    public function onValidationFailure(ValidationException $e)
    {
        return Redirect::action(UserController::class.'@profile')
            ->withInput()
            ->withErrors($e->getValidationErrors());
    }}