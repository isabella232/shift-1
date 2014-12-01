<?php
namespace Tectonic\Shift\Modules\Authentication\Commands;

use Tectonic\Application\Validation\Validator;

class AuthenticateUserValidator extends Validator
{
    /**
     * @var array
     */
    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required'
    ];
}
