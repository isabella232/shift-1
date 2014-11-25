<?php
namespace Tectonic\Shift\Modules\Users\Observers;

use Redirect;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Controllers\HomeController;
use Tectonic\Shift\Library\Traits\Respondable;
use Tectonic\Shift\Modules\Users\Contracts\RegistrationObserverInterface;
use Tectonic\Shift\Modules\Users\Models\User;

/**
 * Class RegistrationResponder
 *
 * This registration listener manages the responses to be sent back to the browser when
 * a given registration request is either successful or fails.
 *
 * @package Tectonic\Shift\Modules\Users\Observers
 */
class RegistrationResponder implements RegistrationObserverInterface
{
    use Respondable;

    /**
     * Called when a validation exception is thrown by the command handler.
     *
     * @param ValidationException $e
     * @return mixed
     */
    public function onValidationError(ValidationException $e)
    {
        return Redirect::action(HomeController::class.'@index')
            ->withInput()
            ->withErrors($e->getValidator());
    }

    /**
     * When registration has succeeded, then the $user object that was created is passed
     * back and can be handled by this observer method.
     *
     * @param User $user
     * @return mixed
     */
    public function onSuccess(User $user)
    {
        return Redirect::action(HomeController::class.'@user');
    }
}
