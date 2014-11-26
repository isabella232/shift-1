<?php
namespace Tectonic\Shift\Modules\Authentication\Contracts;

use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

interface AuthenticationResponderInterface
{
    /**
     * When authentication has succeeded, then the $user object belonging to the newly
     * authenticated user back and can be handled by this observer method.
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

    /**
     * Called when a authentication exception is thrown by the command handler.
     *
     * @param InvalidAuthenticationCredentialsException $e
     * @return mixed
     */
    public function onAuthenticationFailure(InvalidAuthenticationCredentialsException $e);
}