<?php namespace Tectonic\Shift\Modules\Authentication\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class AuthenticationValidation extends Validation
{
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];
}
