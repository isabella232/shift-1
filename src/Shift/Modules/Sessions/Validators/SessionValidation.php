<?php namespace Tectonic\Shift\Modules\Sessions\Validators;

use Tectonic\Shift\Library\Validation\Validation;

class SessionValidation extends Validation
{
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];
}
