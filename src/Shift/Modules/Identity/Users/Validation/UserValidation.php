<?php

namespace Tectonic\Shift\Modules\Identity\Users\Validation;

use Tectonic\Shift\Library\Validation\Validation;

class UserValidation extends Validation
{
    protected $rules = [
        'email'      => 'required|email|unique:users,email',
        'firstName' => 'required',
        'lastName'  => 'required',
        'password'   => 'required|min:6',
        'passwordConfirmation' => 'required|same:password'
    ];
}
