<?php
namespace Tectonic\Shift\Modules\Authentication\Exceptions;

class UserAccountAssociationException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'User is not associated with this account.';
} 