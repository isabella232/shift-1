<?php
namespace Tectonic\Shift\Modules\Authentication\Contracts;

use Tectonic\Application\Validation\ValidationException;
use Tectonic\Shift\Modules\Authentication\Exceptions\InvalidAuthenticationCredentialsException;

interface AuthenticationResponderInterface
{
    public function onSuccess(User $user);

    public function onValidationFailure(ValidationException $e);

    public function onAuthenticationFailure(InvalidAuthenticationCredentialsException $e);
}