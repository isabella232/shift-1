<?php
namespace Tectonic\Shift\Modules\Authentication\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Tectonic\Shift\Controllers\HomeController;
use Tectonic\Shift\Controllers\UserController;
use Tectonic\Shift\Library\Traits\Respondable;
use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Authentication\Contracts\AuthenticationResponderInterface;
use Tectonic\Shift\Modules\Authentication\Exceptions\UserAccountAssociationException;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;
use Tectonic\Shift\Modules\Identity\Users\Models\User;

/**
 * Class AuthenticationResponder
 *
 * This authentication listener manages the responses to be sent back to the browser when
 * an authentication request is either successful or fails.
 *
 * @package Tectonic\Shift\Modules\Authentication\Observers
 */
class AuthenticationResponder implements AuthenticationResponderInterface
{
    use Respondable;

    /**
     * When authentication has succeeded, then the $user object belonging to the newly
     * authenticated user, is passed back and can be handled by this observer method.
     *
     * @param \Tectonic\Shift\Modules\Identity\Users\Models\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onSuccess(User $user)
    {
        return Redirect::action(UserController::class.'@profile');
    }

    /**
     * Called when a validation exception is thrown by the command handler.
     *
     * @param \Tectonic\Application\Validation\ValidationException $e
     *
     * @return $this
     */
    public function onValidationFailure(ValidationException $e)
    {
        return Redirect::action(HomeController::class.'@index')
            ->withInput()
            ->withErrors($e->getValidationErrors());
    }

    /**
     * Called when a authentication exception is thrown by the command handler.
     *
     * @param \Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException $e
     *
     * @return $this
     */
    public function onAuthenticationFailure(InvalidAuthenticationCredentialsException $e)
    {
        $messageBag = new MessageBag([$e->getMessage()]);

        return Redirect::action(HomeController::class.'@index')
            ->withInput()
            ->withErrors($messageBag);
    }

    /**
     * Called when a user-account association exception is thrown by the command handler.
     *
     * @param UserAccountAssociationException $e
     *
     * @return mixed
     */
    public function onUserAccountFailure(UserAccountAssociationException $e)
    {
        $messageBag = new MessageBag([$e->getMessage()]);

        return Redirect::action(HomeController::class.'@index')
            ->withInput()
            ->withErrors($messageBag);
    }}