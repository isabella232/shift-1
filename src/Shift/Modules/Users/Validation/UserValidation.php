<?php

namespace Tectonic\Shift\Modules\Users\Validation;

use Tectonic\Shift\Library\Validation\Validation;

class UserValidation extends Validation
{
    protected $rules = [
        'email'      => 'required|email|unique:users,email',
        'first_name' => 'required',
        'last_name'  => 'required',
        'password'   => 'required|min:6',
        'password_confirmation' => 'required|same:password'
    ];
}
