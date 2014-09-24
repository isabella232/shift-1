<?php

namespace Tectonic\Shift\Modules\Users\Validation;

use Tectonic\Shift\Library\Validation\Validation;

class UserValidation extends Validation
{
    protected $rules = [
        'email' => ['required', 'email'],
        'firstName' => ['required'],
        'lastName' => ['required'],
    ];
}
