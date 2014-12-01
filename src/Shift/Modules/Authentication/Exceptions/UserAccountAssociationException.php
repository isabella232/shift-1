<?php
namespace Tectonic\Shift\Modules\Authentication\Exceptions;

class UserAccountAssociationException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'The login credentials provided are not associated with this account.';
} 