<?php
namespace Tectonic\Shift\Modules\Authentication\Exceptions;

class InvalidAuthenticationCredentialsException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'The login credentials you provided are invalid.';
}